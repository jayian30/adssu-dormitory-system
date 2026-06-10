<?php
class SupervisorController extends BaseController {
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        // Ensure user is logged in and is a supervisor
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'supervisor') {
            $this->redirect('auth/login');
        }
    }

    public function dashboard() {
        $user_id = $_SESSION['user_id'];
        
        // Find which dorms this supervisor manages
        $stmt = $this->pdo->prepare('SELECT id, name FROM dormitories WHERE supervisor_id = ?');
        $stmt->execute([$user_id]);
        $managed_dorms = $stmt->fetchAll();
        $dorm_ids = array_column($managed_dorms, 'id');

        $active_residents = 0;
        $residents = [];

        if (!empty($dorm_ids)) {
            $in_clause = implode(',', array_fill(0, count($dorm_ids), '?'));
            
            // Get active residents
            $stmt = $this->pdo->prepare("
                SELECT u.name, sp.course, r.room_number, d.name as dorm_name, ra.check_in_date
                FROM room_assignments ra
                JOIN users u ON ra.student_id = u.id
                JOIN residents sp ON u.id = sp.user_id
                JOIN dorm_rooms r ON ra.room_id = r.id
                JOIN dormitories d ON r.dorm_id = d.id
                WHERE d.id IN ($in_clause) AND ra.check_out_date IS NULL
                ORDER BY r.room_number, u.name
            ");
            $stmt->execute($dorm_ids);
            $residents = $stmt->fetchAll();
            $active_residents = count($residents);
        }

        $this->view('supervisor/dashboard', [
            'managed_dorms' => $managed_dorms,
            'active_residents' => $active_residents,
            'residents' => $residents
        ]);
    }

    public function attendance() {
        $user_id = $_SESSION['user_id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_POST['student_id'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'] ?? '';
            $date = date('Y-m-d');

            $stmt = $this->pdo->prepare('INSERT INTO attendance (student_id, date, status, remarks, logged_by) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$student_id, $date, $status, $remarks, $user_id]);
            $this->redirect('supervisor/attendance?success=1');
        }

        // Get residents in managed dorms for dropdown
        $stmt = $this->pdo->prepare('
            SELECT u.id, u.name, r.room_number 
            FROM room_assignments ra
            JOIN users u ON ra.student_id = u.id
            JOIN dorm_rooms r ON ra.room_id = r.id
            JOIN dormitories d ON r.dorm_id = d.id
            WHERE d.supervisor_id = ? AND ra.check_out_date IS NULL
            ORDER BY r.room_number, u.name
        ');
        $stmt->execute([$user_id]);
        $residents = $stmt->fetchAll();

        // Get today's attendance logs
        $today = date('Y-m-d');
        $stmt = $this->pdo->prepare('
            SELECT a.*, u.name as student_name 
            FROM attendance a
            JOIN users u ON a.student_id = u.id
            WHERE a.logged_by = ? AND a.date = ?
            ORDER BY a.created_at DESC
        ');
        $stmt->execute([$user_id, $today]);
        $attendance_logs = $stmt->fetchAll();

        $this->view('supervisor/attendance', [
            'residents' => $residents,
            'attendance_logs' => $attendance_logs,
            'today' => $today
        ]);
    }

    public function incidents() {
        $user_id = $_SESSION['user_id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_POST['student_id'];
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $stmt = $this->pdo->prepare('INSERT INTO incidents (student_id, title, description, status, logged_by) VALUES (?, ?, ?, "Pending", ?)');
            $stmt->execute([$student_id, $title, $description, $user_id]);
            $this->redirect('supervisor/incidents?success=1');
        }

        // Get residents in managed dorms for dropdown
        $stmt = $this->pdo->prepare('
            SELECT u.id, u.name, r.room_number 
            FROM room_assignments ra
            JOIN users u ON ra.student_id = u.id
            JOIN dorm_rooms r ON ra.room_id = r.id
            JOIN dormitories d ON r.dorm_id = d.id
            WHERE d.supervisor_id = ? AND ra.check_out_date IS NULL
            ORDER BY r.room_number, u.name
        ');
        $stmt->execute([$user_id]);
        $residents = $stmt->fetchAll();

        // Get incident logs
        $stmt = $this->pdo->prepare('
            SELECT i.*, u.name as student_name 
            FROM incidents i
            JOIN users u ON i.student_id = u.id
            WHERE i.logged_by = ?
            ORDER BY i.created_at DESC
        ');
        $stmt->execute([$user_id]);
        $incident_logs = $stmt->fetchAll();

        $this->view('supervisor/incidents', [
            'residents' => $residents,
            'incident_logs' => $incident_logs
        ]);
    }

    public function cleanliness() {
        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dorm_id = $_POST['dorm_id'];
            $status = $_POST['status'];
            $remarks = trim($_POST['remarks'] ?? '');
            $date = date('Y-m-d');

            $stmt = $this->pdo->prepare('INSERT INTO cleanliness_logs (dorm_id, logged_by, status, remarks, log_date) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$dorm_id, $user_id, $status, $remarks, $date]);
            $this->redirect('supervisor/cleanliness?success=1');
        }

        // Get managed dorms
        $stmt = $this->pdo->prepare('SELECT id, name FROM dormitories WHERE supervisor_id = ?');
        $stmt->execute([$user_id]);
        $managed_dorms = $stmt->fetchAll();

        // Get cleanliness logs
        $stmt = $this->pdo->prepare('
            SELECT c.*, d.name as dorm_name 
            FROM cleanliness_logs c
            JOIN dormitories d ON c.dorm_id = d.id
            WHERE c.logged_by = ?
            ORDER BY c.log_date DESC, c.created_at DESC
        ');
        $stmt->execute([$user_id]);
        $cleanliness_logs = $stmt->fetchAll();

        $this->view('supervisor/cleanliness', [
            'managed_dorms' => $managed_dorms,
            'cleanliness_logs' => $cleanliness_logs
        ]);
    }

    public function residents() {
        $user_id = $_SESSION['user_id'];
        
        $stmt = $this->pdo->prepare('SELECT id FROM dormitories WHERE supervisor_id = ?');
        $stmt->execute([$user_id]);
        $managed_dorms = $stmt->fetchAll();
        $dorm_ids = array_column($managed_dorms, 'id');

        $residents = [];

        if (!empty($dorm_ids)) {
            $in_clause = implode(',', array_fill(0, count($dorm_ids), '?'));
            $stmt = $this->pdo->prepare("
                SELECT u.id as student_id, u.name, u.email, sp.student_id_number, sp.course, sp.year_level, r.room_number, d.name as dorm_name, ra.check_in_date
                FROM room_assignments ra
                JOIN users u ON ra.student_id = u.id
                JOIN residents sp ON u.id = sp.user_id
                JOIN dorm_rooms r ON ra.room_id = r.id
                JOIN dormitories d ON r.dorm_id = d.id
                WHERE d.id IN ($in_clause) AND ra.check_out_date IS NULL
                ORDER BY r.room_number, u.name
            ");
            $stmt->execute($dorm_ids);
            $residents = $stmt->fetchAll();
        }

        if (isset($_GET['export']) && $_GET['export'] === 'csv') {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="residents_list.csv"');
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Name', 'Email', 'Course', 'Year Level', 'Dormitory', 'Room Number', 'Check In']);
            foreach ($residents as $row) {
                fputcsv($output, [
                    $row['name'],
                    $row['email'],
                    $row['course'],
                    $row['year_level'],
                    $row['dorm_name'],
                    $row['room_number'],
                    $row['check_in_date']
                ]);
            }
            fclose($output);
            exit;
        }

        $this->view('supervisor/residents', ['residents' => $residents]);
    }

    public function visitors() {
        $user_id = $_SESSION['user_id'];
        $error = '';
        $success = '';

        // Find which dorms this supervisor manages
        $stmt = $this->pdo->prepare('SELECT id FROM dormitories WHERE supervisor_id = ?');
        $stmt->execute([$user_id]);
        $managed_dorms = $stmt->fetchAll();
        $dorm_ids = array_column($managed_dorms, 'id');

        $residents = [];
        $visitors = [];

        if (!empty($dorm_ids)) {
            $in_clause = implode(',', array_fill(0, count($dorm_ids), '?'));

            // Handle POST requests
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['action'])) {
                    if ($_POST['action'] === 'delete_visitor' && isset($_POST['id'])) {
                        $id = (int)$_POST['id'];
                        // Verify this visitor belongs to a resident in supervisor's managed dorms
                        $check_stmt = $this->pdo->prepare("
                            SELECT COUNT(*) 
                            FROM visitors v
                            JOIN room_assignments ra ON v.student_id = ra.student_id AND ra.check_out_date IS NULL
                            JOIN dorm_rooms dr ON ra.room_id = dr.id
                            WHERE v.id = ? AND dr.dorm_id IN ($in_clause)
                        ");
                        $check_stmt->execute(array_merge([$id], $dorm_ids));
                        
                        if ($check_stmt->fetchColumn() > 0) {
                            $stmt = $this->pdo->prepare("DELETE FROM visitors WHERE id = ?");
                            $stmt->execute([$id]);
                            $this->redirect('supervisor/visitors?deleted=1');
                        } else {
                            $error = 'Access denied or invalid visitor ID.';
                        }
                    } elseif ($_POST['action'] === 'check_out' && isset($_POST['id'])) {
                        $id = (int)$_POST['id'];
                        // Verify this visitor belongs to a resident in supervisor's managed dorms
                        $check_stmt = $this->pdo->prepare("
                            SELECT COUNT(*) 
                            FROM visitors v
                            JOIN room_assignments ra ON v.student_id = ra.student_id AND ra.check_out_date IS NULL
                            JOIN dorm_rooms dr ON ra.room_id = dr.id
                            WHERE v.id = ? AND dr.dorm_id IN ($in_clause)
                        ");
                        $check_stmt->execute(array_merge([$id], $dorm_ids));
                        
                        if ($check_stmt->fetchColumn() > 0) {
                            $stmt = $this->pdo->prepare("UPDATE visitor_logs SET check_out = NOW() WHERE visitor_id = ? AND check_out IS NULL");
                            $stmt->execute([$id]);
                            $this->redirect('supervisor/visitors?checked_out=1');
                        } else {
                            $error = 'Access denied or invalid visitor ID.';
                        }
                    } elseif ($_POST['action'] === 'register_visitor') {
                        $student_id = (int)($_POST['student_id'] ?? 0);
                        $name = trim($_POST['name'] ?? '');
                        $relationship = $_POST['relationship'] ?? '';

                        // Verify this student is in supervisor's managed dorms
                        $check_stmt = $this->pdo->prepare("
                            SELECT COUNT(*) 
                            FROM room_assignments ra
                            JOIN dorm_rooms dr ON ra.room_id = dr.id
                            WHERE ra.student_id = ? AND ra.check_out_date IS NULL AND dr.dorm_id IN ($in_clause)
                        ");
                        $check_stmt->execute(array_merge([$student_id], $dorm_ids));

                        if (empty($name) || empty($relationship) || $student_id <= 0) {
                            $error = 'All fields are required.';
                        } elseif ($check_stmt->fetchColumn() == 0) {
                            $error = 'Selected resident is not in your managed dormitories.';
                        } else {
                            $qr_pass = 'VISIT_' . strtoupper(str_replace(' ', '', $name)) . '_' . time();
                            $stmt = $this->pdo->prepare('INSERT INTO visitors (name, relationship, student_id, qr_visitor_pass) VALUES (?, ?, ?, ?)');
                            $stmt->execute([$name, $relationship, $student_id, $qr_pass]);

                            // Auto-create log entry
                            $visitor_id = $this->pdo->lastInsertId();
                            $stmt = $this->pdo->prepare('INSERT INTO visitor_logs (visitor_id, check_in) VALUES (?, NOW())');
                            $stmt->execute([$visitor_id]);

                            // Fetch student name for activity log
                            $stmt = $this->pdo->prepare('SELECT name FROM users WHERE id = ?');
                            $stmt->execute([$student_id]);
                            $student_name = $stmt->fetchColumn();

                            // Log Action
                            $action_msg = 'Registered visitor: ' . $name . ' for student ' . $student_name;
                            $stmt = $this->pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, ?)");
                            $stmt->execute([$user_id, $action_msg]);

                            $this->redirect('supervisor/visitors?registered=1');
                        }
                    }
                }
            }

            if (isset($_GET['registered'])) {
                $success = 'Visitor pass registered successfully!';
            } elseif (isset($_GET['checked_out'])) {
                $success = 'Visitor successfully checked out.';
            } elseif (isset($_GET['deleted'])) {
                $success = 'Visitor record deleted.';
            }

            // Fetch residents under supervisor's managed dorms
            $stmt = $this->pdo->prepare("
                SELECT u.id, u.name, r.student_id_number, d.name as dorm_name, dr.room_number
                FROM users u
                JOIN residents r ON u.id = r.user_id
                JOIN room_assignments ra ON u.id = ra.student_id AND ra.check_out_date IS NULL
                JOIN dorm_rooms dr ON ra.room_id = dr.id
                JOIN dormitories d ON dr.dorm_id = d.id
                WHERE d.id IN ($in_clause)
                ORDER BY u.name
            ");
            $stmt->execute($dorm_ids);
            $residents = $stmt->fetchAll();

            // Fetch visitors visiting residents in supervised dorms
            $stmt = $this->pdo->prepare("
                SELECT v.*, vl.check_in, vl.check_out, u.name as student_name, dr.room_number, d.name as dorm_name
                FROM visitors v
                LEFT JOIN visitor_logs vl ON v.id = vl.visitor_id
                JOIN users u ON v.student_id = u.id
                JOIN room_assignments ra ON u.id = ra.student_id AND ra.check_out_date IS NULL
                JOIN dorm_rooms dr ON ra.room_id = dr.id
                JOIN dormitories d ON dr.dorm_id = d.id
                WHERE d.id IN ($in_clause)
                ORDER BY vl.check_in DESC, v.id DESC
            ");
            $stmt->execute($dorm_ids);
            $visitors = $stmt->fetchAll();
        }

        $this->view('supervisor/visitors', [
            'error' => $error,
            'success' => $success,
            'residents' => $residents,
            'visitors' => $visitors
        ]);
    }
}
?>
