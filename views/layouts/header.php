<?php
// Start output buffering and session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$dir_name = dirname($_SERVER['SCRIPT_NAME']);
$base_url = ($dir_name == '/' || $dir_name == '\\') ? '' : $dir_name;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADSSU Dormitory Management System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        adssu: {
                            green: '#064e3b',
                            green_light: '#047857',
                            gold: '#fbbf24',
                            gold_hover: '#f59e0b',
                            light: '#f8fafc'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js for Sidebar toggling -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-adssu-light text-slate-800 font-sans antialiased" x-data="{ sidebarOpen: false }">

<?php if (isset($_SESSION['user_id'])): ?>
    <!-- Sidebar Layout -->
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" 
             x-transition.opacity 
             class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden"
             @click="sidebarOpen = false"></div>
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-30 w-64 bg-adssu-green text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col shadow-xl">
            
            <!-- Branding -->
            <div class="flex items-center justify-center h-20 border-b border-adssu-green_light px-6">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 shadow-md">
                    <span class="text-adssu-green font-bold text-xl">A</span>
                </div>
                <h1 class="text-lg font-bold tracking-wider text-white">ADSSU <span class="text-adssu-gold">DORMS</span></h1>
            </div>
            
            <!-- User Profile Area -->
            <div class="px-6 py-6 border-b border-adssu-green_light">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-adssu-gold to-yellow-600 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                        <?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-sm leading-tight"><?php echo htmlspecialchars($_SESSION['name']); ?></p>
                        <p class="text-xs text-slate-300 capitalize mt-1 px-2 py-0.5 bg-adssu-green_light rounded-full inline-block"><?php echo htmlspecialchars($_SESSION['role']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <?php 
                $current_uri = $_SERVER['REQUEST_URI'];
                
                function navLink($url, $icon, $label, $current_uri, $base_url) {
                    $full_url = $base_url . $url;
                    $isActive = strpos($current_uri, $url) !== false;
                    $activeClass = $isActive ? 'bg-adssu-green_light text-white shadow-sm border-l-4 border-adssu-gold' : 'text-slate-300 hover:bg-adssu-green_light/50 hover:text-white border-l-4 border-transparent';
                    echo "<a href='{$full_url}' class='flex items-center px-4 py-3 text-sm font-medium rounded-r-lg transition-colors duration-200 {$activeClass}'>
                            <i class='{$icon} w-6 text-center mr-3'></i>
                            {$label}
                          </a>";
                }

                if ($_SESSION['role'] === 'admin'):
                    navLink('/admin/dashboard', 'fa-solid fa-chart-line', 'Analytics Dashboard', $current_uri, $base_url);
                    navLink('/admin/dormitories', 'fa-solid fa-building', 'Room Management', $current_uri, $base_url);
                    navLink('/admin/applications', 'fa-solid fa-file-signature', 'Applications', $current_uri, $base_url);
                    navLink('/admin/assignments', 'fa-solid fa-door-open', 'Room Assignments', $current_uri, $base_url);
                    navLink('/admin/payments', 'fa-solid fa-file-invoice-dollar', 'Payment Ledger', $current_uri, $base_url);
                    navLink('/admin/visitors', 'fa-solid fa-users-viewfinder', 'Visitor Logs', $current_uri, $base_url);
                    navLink('/admin/announcements', 'fa-solid fa-bullhorn', 'Announcements', $current_uri, $base_url);
                elseif ($_SESSION['role'] === 'supervisor'):
                    navLink('/supervisor/dashboard', 'fa-solid fa-house-user', 'My Dormitories', $current_uri, $base_url);
                    navLink('/supervisor/residents', 'fa-solid fa-users', 'Residents List', $current_uri, $base_url);
                    navLink('/supervisor/attendance', 'fa-solid fa-clipboard-user', 'Attendance Log', $current_uri, $base_url);
                    navLink('/supervisor/visitors', 'fa-solid fa-users-viewfinder', 'Visitor Logs', $current_uri, $base_url);
                    navLink('/supervisor/cleanliness', 'fa-solid fa-broom', 'Cleanliness Log', $current_uri, $base_url);
                    navLink('/supervisor/incidents', 'fa-solid fa-triangle-exclamation', 'Incident Reports', $current_uri, $base_url);
                elseif ($_SESSION['role'] === 'student'):
                    navLink('/student/dashboard', 'fa-solid fa-house', 'Overview', $current_uri, $base_url);
                    navLink('/student/profile', 'fa-solid fa-id-card', 'My Profile & Pass', $current_uri, $base_url);
                    navLink('/student/application', 'fa-solid fa-file-lines', 'Dorm Application', $current_uri, $base_url);
                endif;
                ?>
            </nav>
            
            <!-- Logout -->
            <div class="p-4 border-t border-adssu-green_light">
                <a href="<?php echo $base_url; ?>/auth/logout" class="flex items-center px-4 py-2 text-sm font-medium text-red-300 hover:bg-red-900/30 hover:text-red-200 rounded-lg transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-6 text-center mr-3"></i>
                    Sign Out
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navbar (Mobile toggle & user info) -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 lg:justify-end shadow-sm z-10">
                <button @click="sidebarOpen = true" class="text-slate-500 focus:outline-none lg:hidden">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div class="flex items-center">
                    <span class="text-sm font-medium text-slate-500 mr-2"><?php echo date('l, F j, Y'); ?></span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-adssu-light p-6">
                <!-- Main content will be injected here -->

<?php else: ?>
    <!-- Public Layout (Login/Register) -->
    <div class="min-h-screen bg-adssu-light flex flex-col">
        <!-- Top bar for public pages -->
        <nav class="bg-adssu-green text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center mr-3">
                            <span class="text-adssu-green font-bold text-lg">A</span>
                        </div>
                        <span class="font-bold text-xl tracking-wide">ADSSU <span class="text-adssu-gold">DORMITORY</span></span>
                    </div>
                </div>
            </div>
        </nav>
        <main class="flex-grow flex items-center justify-center p-6">
<?php endif; ?>
