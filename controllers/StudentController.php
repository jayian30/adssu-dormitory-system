<?php
class StudentController extends BaseController {
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        // Ensure user is logged in and is a student
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
            $this->redirect('auth/login');
        }
    }

    public function dashboard() {
        $user_id = $_SESSION['user_id'];
        
        // Get application status
        $stmt = $this->pdo->prepare('SELECT * FROM applications WHERE student_id = ? ORDER BY created_at DESC LIMIT 1');
        $stmt->execute([$user_id]);
        $application = $stmt->fetch();

        // Get room assignment if any (from dorm_rooms and dormitories)
        $stmt = $this->pdo->prepare('
            SELECT ra.*, r.room_number, d.name as dorm_name 
            FROM room_assignments ra 
            JOIN dorm_rooms r ON ra.room_id = r.id 
            JOIN dormitories d ON r.dorm_id = d.id 
            WHERE ra.student_id = ? AND ra.check_out_date IS NULL
            ORDER BY ra.id DESC LIMIT 1
        ');
        $stmt->execute([$user_id]);
        $assignment = $stmt->fetch();

        // Calculate outstanding balance
        $stmt = $this->pdo->prepare("SELECT SUM(amount) as balance FROM payments WHERE student_id = ? AND status = 'Unpaid'");
        $stmt->execute([$user_id]);
        $balance_row = $stmt->fetch();
        $outstanding_balance = $balance_row['balance'] ?? 0.00;

        // Fetch latest announcements
        $stmt = $this->pdo->prepare("SELECT a.*, u.name as author FROM announcements a JOIN users u ON a.created_by = u.id ORDER BY a.created_at DESC LIMIT 5");
        $stmt->execute();
        $announcements = $stmt->fetchAll();

        // Fetch notifications
        $stmt = $this->pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$user_id]);
        $notifications = $stmt->fetchAll();

        // Fetch resident profile QR Code
        $stmt = $this->pdo->prepare("SELECT qr_code, profile_photo FROM residents WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $resident_profile = $stmt->fetch();
        
        if (!$resident_profile) {
            $resident_profile = [];
        }
        
        $qr_code = $resident_profile['qr_code'] ?? 'STUD_' . $user_id . '_QR';

        $this->view('student/dashboard', [
            'application' => $application,
            'room_assignment' => $assignment,
            'outstanding_balance' => $outstanding_balance,
            'announcements' => $announcements,
            'notifications' => $notifications,
            'qr_code' => $qr_code,
            'resident_profile' => $resident_profile
        ]);
    }

    public function application() {
        $user_id = $_SESSION['user_id'];
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $semester = $_POST['semester'] ?? '';
            $room_preference = $_POST['room_preference'] ?? '';
            
            if (empty($semester)) {
                $error = 'Semester is required.';
            } else {
                // Check if already applied for this semester
                $stmt = $this->pdo->prepare('SELECT id FROM applications WHERE student_id = ? AND semester = ?');
                $stmt->execute([$user_id, $semester]);
                if ($stmt->fetch()) {
                    $error = 'You have already applied for this semester.';
                } else {
                    // Document upload simulation
                    $doc_name = 'simulated_document.pdf';
                    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
                        $target_dir = "assets/uploads/";
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0777, true);
                        }
                        $file_ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
                        $doc_name = "doc_" . $user_id . "_" . time() . "." . $file_ext;
                        move_uploaded_file($_FILES['document']['tmp_name'], $target_dir . $doc_name);
                    }

                    // Calculate priority score (Indigenous=50, LowIncome=30, Middle=10)
                    $stmt = $this->pdo->prepare('SELECT income_bracket, is_indigenous FROM residents WHERE user_id = ?');
                    $stmt->execute([$user_id]);
                    $profile = $stmt->fetch();
                    
                    $score = 0;
                    if ($profile) {
                        if ($profile['is_indigenous']) $score += 50;
                        if ($profile['income_bracket'] === 'Low') $score += 30;
                        elseif ($profile['income_bracket'] === 'Middle') $score += 10;
                    }

                    $stmt = $this->pdo->prepare('INSERT INTO applications (student_id, semester, status, priority_score) VALUES (?, ?, "Pending", ?)');
                    $stmt->execute([$user_id, $semester, $score]);
                    
                    // Log Action
                    $stmt = $this->pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, 'Submitted dormitory application for semester')");
                    $stmt->execute([$user_id]);

                    $success = 'Application submitted successfully! Priority evaluation score: ' . $score;
                }
            }
        }

        // Get past applications
        $stmt = $this->pdo->prepare('SELECT * FROM applications WHERE student_id = ? ORDER BY created_at DESC');
        $stmt->execute([$user_id]);
        $applications = $stmt->fetchAll();

        $this->view('student/application', [
            'error' => $error,
            'success' => $success,
            'applications' => $applications
        ]);
    }

    public function fees() {
        $user_id = $_SESSION['user_id'];
        
        $stmt = $this->pdo->prepare('SELECT * FROM payments WHERE student_id = ? ORDER BY due_date DESC');
        $stmt->execute([$user_id]);
        $payments = $stmt->fetchAll();

        $this->view('student/fees', [
            'fees' => $payments
        ]);
    }

    public function maintenance() {
        $user_id = $_SESSION['user_id'];
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            if (empty($title) || empty($description)) {
                $error = 'Both issue title and details are required.';
            } else {
                $photo_name = null;
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $target_dir = "assets/uploads/";
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    $file_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $photo_name = "maintenance_" . $user_id . "_" . time() . "." . $file_ext;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir . $photo_name);
                }

                $stmt = $this->pdo->prepare('INSERT INTO maintenance_requests (student_id, issue_title, description, photo_path, status) VALUES (?, ?, ?, ?, "Pending")');
                $stmt->execute([$user_id, $title, $description, $photo_name]);
                
                // Log Action
                $stmt = $this->pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, 'Logged maintenance ticket: ' ?)");
                $stmt->execute([$user_id, $title]);

                $success = 'Maintenance ticket submitted successfully! Maintenance team will resolve it soon.';
            }
        }

        // Get past tickets
        $stmt = $this->pdo->prepare('SELECT * FROM maintenance_requests WHERE student_id = ? ORDER BY created_at DESC');
        $stmt->execute([$user_id]);
        $tickets = $stmt->fetchAll();

        $this->view('student/maintenance', [
            'error' => $error,
            'success' => $success,
            'tickets' => $tickets
        ]);
    }

    public function visitors() {
        $this->redirect('student/dashboard');
    }

    public function profile() {
        $user_id = $_SESSION['user_id'];
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $income_bracket = $_POST['income_bracket'] ?? 'Middle';
            $is_indigenous = isset($_POST['is_indigenous']) ? 1 : 0;
            $new_password = $_POST['new_password'] ?? '';

            // Check if resident exists
            $stmt = $this->pdo->prepare('SELECT id FROM residents WHERE user_id = ?');
            $stmt->execute([$user_id]);
            if ($stmt->fetch()) {
                $stmt = $this->pdo->prepare('UPDATE residents SET income_bracket = ?, is_indigenous = ? WHERE user_id = ?');
                $stmt->execute([$income_bracket, $is_indigenous, $user_id]);
            } else {
                $stmt = $this->pdo->prepare('INSERT INTO residents (user_id, student_id_number, course, year_level, income_bracket, is_indigenous, qr_code) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$user_id, 'N/A', 'N/A', 1, $income_bracket, $is_indigenous, 'STUD_' . $user_id . '_' . time()]);
            }

            if (!empty($new_password)) {
                $hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                $stmt->execute([$hash, $user_id]);
            }

            $success = 'Profile updated successfully.';
        }

        $stmt = $this->pdo->prepare('
            SELECT u.name, u.email, r.student_id_number, r.course, r.year_level, r.income_bracket, r.is_indigenous, r.qr_code
            FROM users u
            LEFT JOIN residents r ON u.id = r.user_id
            WHERE u.id = ?
        ');
        $stmt->execute([$user_id]);
        $profile = $stmt->fetch();
        
        if (!$profile) {
            $profile = ['name' => $_SESSION['name'], 'email' => ''];
        }
        
        $profile['student_id_number'] = $profile['student_id_number'] ?? 'N/A';
        $profile['course'] = $profile['course'] ?? 'N/A';
        $profile['year_level'] = $profile['year_level'] ?? 1;
        $profile['income_bracket'] = $profile['income_bracket'] ?? 'Middle';
        $profile['is_indigenous'] = $profile['is_indigenous'] ?? 0;
        $profile['qr_code'] = $profile['qr_code'] ?? 'STUD_' . $user_id . '_' . time();

        $this->view('student/profile', [
            'profile' => $profile,
            'success' => $success,
            'error' => $error
        ]);
    }
}
?>
