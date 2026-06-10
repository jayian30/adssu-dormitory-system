<?php include 'views/layouts/header.php'; ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <p class="text-slate-500">Here's your dormitory overview and status.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Status Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center border-b border-slate-100 pb-3">
            <i class="fa-solid fa-building-circle-check text-adssu-green mr-2"></i> Current Status
        </h3>
        
        <?php if ($room_assignment): ?>
            <div class="text-center mb-6 pt-2">
                <span class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-800 rounded-full text-xs font-extrabold tracking-widest mb-3 uppercase">Checked In</span>
                <h4 class="text-2xl font-bold text-slate-800 leading-tight"><?php echo htmlspecialchars($room_assignment['dorm_name']); ?></h4>
                <p class="text-adssu-green font-semibold text-lg mt-1">Room <?php echo htmlspecialchars($room_assignment['room_number']); ?></p>
            </div>
            
            <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-medium text-slate-500">Check-in Date</span>
                    <span class="text-sm font-bold text-slate-700"><?php echo date('M d, Y', strtotime($room_assignment['check_in_date'])); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-slate-500">Term/Semester</span>
                    <span class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($room_assignment['semester']); ?></span>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-6">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-3">
                    <i class="fa-solid fa-house-circle-xmark"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">No Active Assignment</h4>
                <p class="text-slate-500 text-sm mt-1 mb-6">You are not currently assigned to a room.</p>
                <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/student/application" class="inline-block px-6 py-2.5 bg-adssu-green text-white rounded-lg hover:bg-adssu-green_light transition-colors text-sm font-semibold shadow-sm">Apply for Dormitory</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center border-b border-slate-100 pb-3">
            <i class="fa-solid fa-bolt text-adssu-gold_hover mr-2"></i> Quick Actions
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/student/application" class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-xl border border-slate-200 hover:bg-adssu-green hover:text-white hover:border-adssu-green transition-all duration-300 group shadow-sm">
                <i class="fa-solid fa-file-lines text-2xl mb-2 text-slate-400 group-hover:text-white transition-colors"></i>
                <span class="text-xs font-bold text-center">Dorm Application</span>
            </a>
            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/student/profile" class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-xl border border-slate-200 hover:bg-adssu-green hover:text-white hover:border-adssu-green transition-all duration-300 group shadow-sm">
                <i class="fa-solid fa-qrcode text-2xl mb-2 text-slate-400 group-hover:text-white transition-colors"></i>
                <span class="text-xs font-bold text-center">View ID Pass</span>
            </a>
        </div>
        
        <div class="mt-6 text-center">
            <div class="inline-block p-2 bg-white border border-slate-200 rounded-xl shadow-sm">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?php echo urlencode($qr_code); ?>" alt="Resident QR Code" class="w-24 h-24 mx-auto rounded">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-2">Scan at Gate</p>
            </div>
        </div>
    </div>
    
    <!-- Recent Announcements -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center border-b border-slate-100 pb-3">
            <i class="fa-solid fa-bullhorn text-blue-500 mr-2"></i> Recent Announcements
        </h3>
        <?php if (empty($announcements)): ?>
            <div class="h-40 flex flex-col items-center justify-center text-slate-400">
                <i class="fa-regular fa-bell-slash text-3xl mb-2"></i>
                <p class="text-sm">No recent announcements.</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($announcements as $ann): ?>
                    <div class="border-l-4 <?php echo $ann['is_emergency'] ? 'border-red-500 bg-red-50' : 'border-blue-500 bg-slate-50'; ?> p-4 rounded-r-xl">
                        <div class="flex justify-between items-start mb-1.5">
                            <h4 class="font-bold <?php echo $ann['is_emergency'] ? 'text-red-800' : 'text-slate-800'; ?> text-sm leading-tight pr-2"><?php echo htmlspecialchars($ann['title']); ?></h4>
                            <?php if ($ann['is_emergency']): ?>
                                <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded uppercase font-bold tracking-wider shrink-0 mt-0.5">Urgent</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-xs text-slate-600 mb-2.5 line-clamp-2 leading-relaxed"><?php echo htmlspecialchars($ann['content']); ?></p>
                        <span class="text-[10px] font-semibold text-slate-400 flex items-center"><i class="fa-regular fa-clock mr-1"></i><?php echo date('M d, Y', strtotime($ann['created_at'])); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
