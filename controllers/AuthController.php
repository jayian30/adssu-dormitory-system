<?php
class AuthController extends BaseController {
    public function login() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                $this->redirect('admin/dashboard');
            } elseif ($_SESSION['role'] === 'supervisor') {
                $this->redirect('supervisor/dashboard');
            } else {
                $this->redirect('student/dashboard');
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $error = '';

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];

                    if ($user['role'] === 'admin') {
                        $this->redirect('admin/dashboard');
                    } elseif ($user['role'] === 'supervisor') {
                        $this->redirect('supervisor/dashboard');
                    } else {
                        $this->redirect('student/dashboard');
                    }
                } else {
                    $error = 'Invalid email or password.';
                }
            }

            $this->view('auth/login', ['error' => $error, 'email' => $email]);
        } else {
            $this->view('auth/login');
        }
    }

    public function register() {
        // Public registration disabled, only admin can register students.
        $this->redirect('auth/login');
        
        if (isset($_SESSION['user_id'])) {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $student_id_number = trim($_POST['student_id_number'] ?? '');
            $course = trim($_POST['course'] ?? '');
            $year_level = (int)($_POST['year_level'] ?? 1);
            $income_bracket = $_POST['income_bracket'] ?? 'Middle';
            $is_indigenous = isset($_POST['is_indigenous']) ? 1 : 0;
            
            $error = '';

            if (empty($name) || empty($email) || empty($password) || empty($student_id_number) || empty($course)) {
                $error = 'Please fill in all required fields.';
            } else {
                // Check if email or student ID exists
                $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ?');
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = 'Email is already registered.';
                } else {
                    $stmt = $this->pdo->prepare('SELECT user_id FROM residents WHERE student_id_number = ?');
                    $stmt->execute([$student_id_number]);
                    if ($stmt->fetch()) {
                        $error = 'Student ID number is already registered.';
                    } else {
                        try {
                            $this->pdo->beginTransaction();
                            
                            $password_hash = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, "student")');
                            $stmt->execute([$name, $email, $password_hash]);
                            $user_id = $this->pdo->lastInsertId();

                            $qr_code = 'STUD_' . $user_id . '_' . time();
                            $stmt = $this->pdo->prepare('INSERT INTO residents (user_id, student_id_number, course, year_level, income_bracket, is_indigenous, qr_code) VALUES (?, ?, ?, ?, ?, ?, ?)');
                            $stmt->execute([$user_id, $student_id_number, $course, $year_level, $income_bracket, $is_indigenous, $qr_code]);

                            $this->pdo->commit();
                            
                            $this->redirect('auth/login?registered=1');
                        } catch (Exception $e) {
                            $this->pdo->rollBack();
                            $error = 'Registration failed: ' . $e->getMessage();
                        }
                    }
                }
            }

            $this->view('auth/register', [
                'error' => $error,
                'name' => $name,
                'email' => $email,
                'student_id_number' => $student_id_number,
                'course' => $course,
                'year_level' => $year_level,
                'income_bracket' => $income_bracket,
                'is_indigenous' => $is_indigenous
            ]);
        } else {
            $this->view('auth/register');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }
}
?>
