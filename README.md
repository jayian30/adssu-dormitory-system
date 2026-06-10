# ADSSU Dormitory Management System

A comprehensive, role-based web application for managing dormitories, residents, and facilities at ADSSU. Built with a custom PHP MVC architecture and MySQL.

## Features

- **Role-Based Access Control**: Secure login for Students, Supervisors, and OSAS Admins.
- **Student Portal**: Dormitory applications, room assignment viewing, and fee tracking.
- **Supervisor Portal**: Daily attendance logging and resident monitoring.
- **Admin Portal**: Approve applications, manage dormitories/rooms, and monitor occupancy.
- **Automated Priority Scoring**: Dormitory application priority based on income bracket and indigenous group status.

## Technology Stack

- **Backend**: Vanilla PHP 8+ (Custom MVC Router)
- **Database**: MySQL (PDO)
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla), Bootstrap 5
- **Icons/Fonts**: Google Fonts (Inter)

## Installation Guide

1. **Prerequisites**: Ensure you have XAMPP installed.
2. **Clone / Extract**: Place the project folder (`ADSSU DORMITORY SYSTEM`) into your `c:\xampp\htdocs\` directory.
3. **Database Setup**:
   - Open XAMPP Control Panel and start **Apache** and **MySQL**.
   - Open your browser and go to `http://localhost/phpmyadmin`.
   - The database will automatically be created when you import the script. Go to the "Import" tab and upload the `database.sql` file located in the root directory.
4. **Configuration**:
   - If your MySQL user/password is different from the XAMPP default (`root` / `no password`), update `config/db.php`.
5. **Run the Application**:
   - Open your browser and navigate to `http://localhost/ADSSU%20DORMITORY%20SYSTEM/`.
   - The application uses an `.htaccess` file to rewrite URLs to `index.php`. Make sure Apache's `mod_rewrite` is enabled (it is by default in XAMPP).

## Default Accounts

- **Admin Account** (Desktop App): 
  - Email: `admin@adssu.edu.ph`
  - Password: `password`

- **Supervisor Account** (Web Portal): 
  - Email: `supervisor@adssu.edu.ph`
  - Password: `password`

- **Student Account** (Web Portal): 
  - Email: `student@adssu.edu.ph`
  - Password: `password`

## Developer Notes

- The project uses a lightweight custom MVC structure. All requests are routed through `index.php` and handled by the respective controllers in `/controllers`.
- Styles are defined in `assets/css/style.css` utilizing custom CSS variables.
- Dynamic behaviors are contained in `assets/js/script.js`.
