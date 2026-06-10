<?php include 'views/layouts/header.php'; ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Supervisor Dashboard</h2>
    <p class="text-slate-500">Monitor your assigned dormitories and residents.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Stat Cards -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mr-4 border border-emerald-100">
            <i class="fa-solid fa-building"></i>
        </div>
        <div>
            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Managed Dorms</p>
            <h3 class="text-2xl font-bold text-slate-800"><?php echo count($managed_dorms); ?></h3>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mr-4 border border-blue-100">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Active Residents</p>
            <h3 class="text-2xl font-bold text-slate-800"><?php echo $active_residents; ?></h3>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mr-4 border border-amber-100">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Action Required</p>
            <h3 class="text-2xl font-bold text-slate-800">0</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800 flex items-center">
            <i class="fa-solid fa-list-ul text-adssu-green mr-3 bg-adssu-green/10 p-2 rounded-lg"></i> 
            Recent Residents
        </h3>
        <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/supervisor/residents" class="text-sm font-semibold text-adssu-green hover:text-adssu-green_light transition-colors px-3 py-1.5 rounded-lg hover:bg-adssu-green/5">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Resident Name</th>
                    <th class="px-6 py-4">Dormitory</th>
                    <th class="px-6 py-4 text-center">Room</th>
                    <th class="px-6 py-4 text-right">Check-In</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($residents)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <i class="fa-solid fa-inbox text-slate-300 text-4xl mb-3 block"></i>
                            <span class="text-slate-500 font-medium">No residents assigned to your dorms yet.</span>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $count = 0; foreach ($residents as $res): if($count++ >= 5) break; ?>
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-adssu-green text-white flex items-center justify-center font-bold text-xs mr-3">
                                    <?php echo strtoupper(substr($res['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800"><?php echo htmlspecialchars($res['name']); ?></div>
                                    <div class="text-[11px] text-slate-500 mt-0.5"><?php echo htmlspecialchars($res['course']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-slate-700 font-medium"><?php echo htmlspecialchars($res['dorm_name']); ?></span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-adssu-gold/10 text-adssu-gold_hover border border-adssu-gold/20 font-mono text-xs font-bold">
                                <i class="fa-solid fa-door-closed mr-1.5 opacity-70"></i><?php echo htmlspecialchars($res['room_number']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium text-right">
                            <?php echo date('M d, Y', strtotime($res['check_in_date'])); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
