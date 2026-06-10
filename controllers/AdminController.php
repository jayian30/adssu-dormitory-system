<?php
class AdminController extends BaseController {
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        // Ensure user is logged in and is an admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('auth/login');
        }
    }

    public function dashboard() {
        // Fetch stats
        $stmt = $this->pdo->query('SELECT COUNT(*) as total FROM dormitories');
        $total_dorms = $stmt->fetch()['total'] ?? 0;

        $stmt = $this->pdo->query('SELECT SUM(capacity) as total_capacity, SUM(current_occupancy) as total_occupancy FROM dorm_rooms');
        $room_stats = $stmt->fetch();
        $total_capacity = $room_stats['total_capacity'] ?? 0;
        $total_occupancy = $room_stats['total_occupancy'] ?? 0;
        $occupancy_rate = $total_capacity > 0 ? round(($total_occupancy / $total_capacity) * 100) : 0;
        
        $stmt = $this->pdo->query("SELECT COUNT(*) as pending FROM applications WHERE status = 'Pending'");
        $pending_applications = $stmt->fetch()['pending'] ?? 0;

        $stmt = $this->pdo->query("SELECT COUNT(*) as pending FROM maintenance_requests WHERE status = 'Pending'");
        $pending_maintenance = $stmt->fetch()['pending'] ?? 0;

        $stmt = $this->pdo->query("SELECT SUM(amount) as total FROM payments WHERE status = 'Unpaid'");
        $unpaid_fees = $stmt->fetch()['total'] ?? 0;

        // Fetch recent applications
        $stmt = $this->pdo->query("SELECT a.*, u.name as student_name FROM applications a JOIN users u ON a.student_id = u.id ORDER BY a.created_at DESC LIMIT 5");
        $recent_applications = $stmt->fetchAll();

        // Fetch occupancy by dorm for chart
        $stmt = $this->pdo->query("
            SELECT d.name, SUM(r.current_occupancy) as occupancy, SUM(r.capacity) as capacity 
            FROM dormitories d 
            LEFT JOIN dorm_rooms r ON d.id = r.dorm_id 
            GROUP BY d.id
        ");
        $dorm_occupancy = $stmt->fetchAll();

        $this->view('admin/dashboard', [
            'total_dorms' => $total_dorms,
            'total_capacity' => $total_capacity,
            'total_occupancy' => $total_occupancy,
            'occupancy_rate' => $occupancy_rate,
            'pending_applications' => $pending_applications,
            'pending_maintenance' => $pending_maintenance,
            'unpaid_fees' => $unpaid_fees,
            'recent_applications' => $recent_applications,
            'dorm_occupancy' => $dorm_occupancy
        ]);
    }

    public function dormitories() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'add_dormitory') {
                $name = trim($_POST['name'] ?? '');
                $gender = $_POST['gender_type'] ?? 'Co-ed';
                $capacity = (int)$_POST['capacity'];
                $sup_id = (int)$_POST['supervisor_id'];
                
                $stmt = $this->pdo->prepare("INSERT INTO dormitories (name, gender_type, capacity, supervisor_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $gender, $capacity, $sup_id]);
            }
            $this->redirect('admin/dormitories');
        }

        $stmt = $this->pdo->query("SELECT id, name FROM users WHERE role = 'supervisor'");
        $supervisors = $stmt->fetchAll();

        $stmt = $this->pdo->query("
            SELECT d.*, u.name as supervisor_name, 
            (SELECT COUNT(*) FROM dorm_rooms WHERE dorm_id = d.id) as total_rooms,
            (SELECT SUM(capacity) FROM dorm_rooms WHERE dorm_id = d.id) as capacity,
            (SELECT SUM(current_occupancy) FROM dorm_rooms WHERE dorm_id = d.id) as occupancy
            FROM dormitories d 
            LEFT JOIN users u ON d.supervisor_id = u.id
        ");
        $dormitories = $stmt->fetchAll();
        $this->view('admin/dormitories', [
            'dormitories' => $dormitories,
            'supervisors' => $supervisors
        ]);
    }

    public function applications() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && isset($_POST['id'])) {
                $id = (int)$_POST['id'];
                if ($_POST['action'] === 'approve') {
                    $stmt = $this->pdo->prepare("UPDATE applications SET status = 'Approved' WHERE id = ?");
                    $stmt->execute([$id]);
                } elseif ($_POST['action'] === 'reject') {
                    $stmt = $this->pdo->prepare("UPDATE applications SET status = 'Rejected' WHERE id = ?");
                    $stmt->execute([$id]);
                }
            }
            $this->redirect('admin/applications');
        }

        $stmt = $this->pdo->query("
            SELECT a.*, u.name as student_name, r.course, r.year_level, r.income_bracket, r.is_indigenous
            FROM applications a 
            JOIN users u ON a.student_id = u.id
            JOIN residents r ON u.id = r.user_id
            ORDER BY a.priority_score DESC, a.created_at ASC
        ");
        $applications = $stmt->fetchAll();
        $this->view('admin/applications', ['applications' => $applications]);
    }

    public function assignments() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'assign_room') {
                $student_id = (int)$_POST['student_id'];
                $room_id = (int)$_POST['room_id'];
                $semester = trim($_POST['semester'] ?? '');
                $check_in = trim($_POST['check_in_date'] ?? date('Y-m-d'));
                
                // Update dorm_rooms current_occupancy
                $this->pdo->prepare("UPDATE dorm_rooms SET current_occupancy = current_occupancy + 1 WHERE id = ?")->execute([$room_id]);
                
                $stmt = $this->pdo->prepare("INSERT INTO room_assignments (student_id, room_id, semester, check_in_date) VALUES (?, ?, ?, ?)");
                $stmt->execute([$student_id, $room_id, $semester, $check_in]);
            }
            $this->redirect('admin/assignments');
        }

        $stmt = $this->pdo->query("SELECT id, name FROM users WHERE role = 'student'");
        $students = $stmt->fetchAll();

        $stmt = $this->pdo->query("SELECT r.id, r.room_number, d.name as dorm_name FROM dorm_rooms r JOIN dormitories d ON r.dorm_id = d.id WHERE r.current_occupancy < r.capacity");
        $rooms = $stmt->fetchAll();

        $stmt = $this->pdo->query("
            SELECT ra.*, u.name as student_name, r.room_number, d.name as dorm_name
            FROM room_assignments ra
            JOIN users u ON ra.student_id = u.id
            JOIN dorm_rooms r ON ra.room_id = r.id
            JOIN dormitories d ON r.dorm_id = d.id
            ORDER BY ra.check_in_date DESC
        ");
        $assignments = $stmt->fetchAll();
        $this->view('admin/assignments', [
            'assignments' => $assignments,
            'students' => $students,
            'rooms' => $rooms
        ]);
    }

    public function payments() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'mark_paid' && isset($_POST['id'])) {
                $id = (int)$_POST['id'];
                $stmt = $this->pdo->prepare("UPDATE payments SET status = 'Paid', paid_date = CURRENT_DATE WHERE id = ?");
                $stmt->execute([$id]);
            }
            $this->redirect('admin/payments');
        }

        $stmt = $this->pdo->query("
            SELECT p.*, u.name as student_name
            FROM payments p
            JOIN users u ON p.student_id = u.id
            ORDER BY p.due_date DESC
        ");
        $payments = $stmt->fetchAll();
        $this->view('admin/payments', ['payments' => $payments]);
    }

    public function announcements() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
                    $id = (int)$_POST['id'];
                    $stmt = $this->pdo->prepare("DELETE FROM announcements WHERE id = ?");
                    $stmt->execute([$id]);
                } elseif ($_POST['action'] === 'post_announcement') {
                    $title = trim($_POST['title'] ?? '');
                    $content = trim($_POST['content'] ?? '');
                    $is_emergency = isset($_POST['is_emergency']) ? 1 : 0;
                    if ($title && $content) {
                        $stmt = $this->pdo->prepare("INSERT INTO announcements (title, content, is_emergency, created_by) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$title, $content, $is_emergency, $_SESSION['user_id']]);
                    }
                }
            }
            $this->redirect('admin/announcements');
        }

        $stmt = $this->pdo->query("
            SELECT a.*, u.name as author_name
            FROM announcements a
            JOIN users u ON a.created_by = u.id
            ORDER BY a.created_at DESC
        ");
        $announcements = $stmt->fetchAll();
        $this->view('admin/announcements', ['announcements' => $announcements]);
    }

    public function visitors() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                if ($_POST['action'] === 'delete_visitor' && isset($_POST['id'])) {
                    $id = (int)$_POST['id'];
                    $stmt = $this->pdo->prepare("DELETE FROM visitors WHERE id = ?");
                    $stmt->execute([$id]);
                    $this->redirect('admin/visitors?deleted=1');
                } elseif ($_POST['action'] === 'check_out' && isset($_POST['id'])) {
                    $id = (int)$_POST['id'];
                    $stmt = $this->pdo->prepare("UPDATE visitor_logs SET check_out = NOW() WHERE visitor_id = ? AND check_out IS NULL");
                    $stmt->execute([$id]);
                    $this->redirect('admin/visitors?checked_out=1');
                } elseif ($_POST['action'] === 'register_visitor') {
                    $student_id = (int)($_POST['student_id'] ?? 0);
                    $name = trim($_POST['name'] ?? '');
                    $relationship = trim($_POST['relationship'] ?? '');

                    if (empty($name) || empty($relationship) || $student_id <= 0) {
                        $error = 'All fields are required.';
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
                        $stmt->execute([$_SESSION['user_id'], $action_msg]);

                        $this->redirect('admin/visitors?registered=1');
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

        // Get list of active residents for registration dropdown
        $stmt = $this->pdo->query("
            SELECT u.id, u.name, r.student_id_number, d.name as dorm_name, dr.room_number
            FROM users u
            JOIN residents r ON u.id = r.user_id
            JOIN room_assignments ra ON u.id = ra.student_id AND ra.check_out_date IS NULL
            JOIN dorm_rooms dr ON ra.room_id = dr.id
            JOIN dormitories d ON dr.dorm_id = d.id
            ORDER BY u.name
        ");
        $residents = $stmt->fetchAll();

        // Get visitor list and check-in times
        $stmt = $this->pdo->query("
            SELECT v.*, vl.check_in, vl.check_out, u.name as student_name, dr.room_number, d.name as dorm_name
            FROM visitors v
            LEFT JOIN visitor_logs vl ON v.id = vl.visitor_id
            JOIN users u ON v.student_id = u.id
            LEFT JOIN room_assignments ra ON u.id = ra.student_id AND ra.check_out_date IS NULL
            LEFT JOIN dorm_rooms dr ON ra.room_id = dr.id
            LEFT JOIN dormitories d ON dr.dorm_id = d.id
            ORDER BY vl.check_in DESC, v.id DESC
        ");
        $visitors = $stmt->fetchAll();

        $this->view('admin/visitors', [
            'error' => $error,
            'success' => $success,
            'residents' => $residents,
            'visitors' => $visitors
        ]);
    }
}
?>
