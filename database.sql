-- Users table (Handles Authentication for all roles)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'supervisor', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Residents (Extended academic and profile info for students)
CREATE TABLE IF NOT EXISTS residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    student_id_number VARCHAR(50) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    year_level INT NOT NULL,
    income_bracket ENUM('Low', 'Middle', 'High') DEFAULT 'Middle',
    is_indigenous BOOLEAN DEFAULT FALSE,
    profile_photo VARCHAR(255) DEFAULT NULL,
    qr_code VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Dormitories (Managed by OSAS Admin)
CREATE TABLE IF NOT EXISTS dormitories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender_type ENUM('Male', 'Female', 'Co-ed') NOT NULL,
    capacity INT NOT NULL,
    supervisor_id INT, -- Refers to a user with role 'supervisor'
    FOREIGN KEY (supervisor_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Rooms inside dormitories
CREATE TABLE IF NOT EXISTS dorm_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dorm_id INT NOT NULL,
    room_number VARCHAR(20) NOT NULL,
    capacity INT NOT NULL,
    current_occupancy INT DEFAULT 0,
    FOREIGN KEY (dorm_id) REFERENCES dormitories(id) ON DELETE CASCADE
);

-- Applications for Dormitory
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL, -- Refers to users(id)
    semester VARCHAR(50) NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    priority_score INT DEFAULT 0, -- Calculated based on income/indigenous
    uploaded_documents VARCHAR(255) DEFAULT NULL,
    interview_date DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Room Assignments
CREATE TABLE IF NOT EXISTS room_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    room_id INT NOT NULL,
    semester VARCHAR(50) NOT NULL,
    check_in_date DATE,
    check_out_date DATE NULL,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES dorm_rooms(id) ON DELETE CASCADE
);

-- Payments & Billing (replaces fees)
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid',
    due_date DATE NOT NULL,
    paid_date DATE NULL,
    receipt_number VARCHAR(50) DEFAULT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Visitors table
CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    relationship VARCHAR(100) NOT NULL,
    student_id INT NOT NULL,
    qr_visitor_pass VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Visitor logs table
CREATE TABLE IF NOT EXISTS visitor_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visitor_id INT NOT NULL,
    check_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    check_out TIMESTAMP NULL,
    FOREIGN KEY (visitor_id) REFERENCES visitors(id) ON DELETE CASCADE
);

-- Maintenance Requests (replaces incidents / logs issue tickets)
CREATE TABLE IF NOT EXISTS maintenance_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    issue_title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    photo_path VARCHAR(255) DEFAULT NULL,
    status ENUM('Pending', 'Assigned', 'Resolved') DEFAULT 'Pending',
    assigned_staff VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Announcements table
CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    is_emergency BOOLEAN DEFAULT FALSE,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Notifications table
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Activity Logs
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Attendance (Supervisor daily monitoring)
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('Present', 'Absent', 'Late') NOT NULL,
    remarks VARCHAR(255) NULL,
    logged_by INT NOT NULL, -- Supervisor ID
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (logged_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Cleanliness logs table (Logged by Supervisors)
CREATE TABLE IF NOT EXISTS cleanliness_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dorm_id INT NOT NULL,
    logged_by INT NOT NULL, -- Supervisor ID
    status ENUM('Excellent', 'Good', 'Fair', 'Poor') NOT NULL,
    remarks TEXT NULL,
    log_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dorm_id) REFERENCES dormitories(id) ON DELETE CASCADE,
    FOREIGN KEY (logged_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Seeding Default/Mock Accounts (Password is 'password')
INSERT INTO users (id, name, email, password_hash, role) VALUES 
(1, 'OSAS Admin', 'admin@adssu.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
(2, 'Maria Santos', 'supervisor@adssu.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'supervisor'),
(3, 'Juan Dela Cruz', 'student@adssu.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student'),
(4, 'Jane Doe', 'jane@adssu.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student')
ON DUPLICATE KEY UPDATE email=VALUES(email);

-- Insert Residents Data
INSERT INTO residents (user_id, student_id_number, course, year_level, income_bracket, is_indigenous, qr_code) VALUES
(3, '2023-0001', 'BS Information Technology', 3, 'Low', TRUE, 'STUD_JUAN_QR'),
(4, '2024-0512', 'BS Hospitality Management', 2, 'Middle', FALSE, 'STUD_JANE_QR')
ON DUPLICATE KEY UPDATE student_id_number=VALUES(student_id_number);

-- Insert Dormitories
INSERT INTO dormitories (id, name, gender_type, capacity, supervisor_id) VALUES
(1, 'Laguna Hall (Male)', 'Male', 50, 2),
(2, 'Sampaguita Hall (Female)', 'Female', 50, 2)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Insert Rooms (dorm_rooms)
INSERT INTO dorm_rooms (id, dorm_id, room_number, capacity, current_occupancy) VALUES
(1, 1, 'M-101', 4, 1),
(2, 1, 'M-102', 4, 0),
(3, 2, 'F-101', 4, 1),
(4, 2, 'F-102', 4, 0)
ON DUPLICATE KEY UPDATE room_number=VALUES(room_number);

-- Insert Applications
INSERT INTO applications (id, student_id, semester, status, priority_score) VALUES
(1, 3, '1st Semester 2026-2027', 'Approved', 80),
(2, 4, '1st Semester 2026-2027', 'Approved', 10)
ON DUPLICATE KEY UPDATE status=VALUES(status);

-- Insert Room Assignments
INSERT INTO room_assignments (id, student_id, room_id, semester, check_in_date) VALUES
(1, 3, 1, '1st Semester 2026-2027', '2026-06-01'),
(2, 4, 3, '1st Semester 2026-2027', '2026-06-02')
ON DUPLICATE KEY UPDATE semester=VALUES(semester);

-- Insert Payments (replaces fees)
INSERT INTO payments (id, student_id, amount, description, status, due_date) VALUES
(1, 3, 1500.00, 'Dorm Monthly Fee - June 2026', 'Unpaid', '2026-06-15'),
(2, 3, 150.00, 'Dorm Association Fee', 'Paid', '2026-06-05'),
(3, 4, 1500.00, 'Dorm Monthly Fee - June 2026', 'Unpaid', '2026-06-15')
ON DUPLICATE KEY UPDATE description=VALUES(description);

-- Insert Maintenance Requests
INSERT INTO maintenance_requests (id, student_id, issue_title, description, status) VALUES
(1, 3, 'Leaking Water Pipe', 'The water pipe in Room M-101 bathroom has a slow leak and needs sealing.', 'Pending')
ON DUPLICATE KEY UPDATE issue_title=VALUES(issue_title);

-- Insert Announcements
INSERT INTO announcements (id, title, content, is_emergency, created_by) VALUES
(1, 'General Clean-up Drive', 'All dormitory residents are required to participate in the general cleaning of premises this Saturday.', FALSE, 1),
(2, 'Urgent Water Supply Interrupt', 'Maintenance will be working on the main pipes today at 2 PM. Water supply will be cut temporarily.', TRUE, 1)
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- Insert Visitors
INSERT INTO visitors (id, name, relationship, student_id, qr_visitor_pass) VALUES
(1, 'Juan Dela Cruz Sr.', 'Father', 3, 'VISIT_JUANSR_QR')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Insert Visitor Logs
INSERT INTO visitor_logs (id, visitor_id, check_in) VALUES
(1, 1, '2026-05-24 10:00:00')
ON DUPLICATE KEY UPDATE visitor_id=VALUES(visitor_id);

-- Activities table
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NULL,
    activity_date DATE NOT NULL,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);
