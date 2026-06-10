<?php include 'views/layouts/header.php'; ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Dormitory Residents</h2>
        <p class="text-slate-500">Directory of students currently residing in your managed halls.</p>
    </div>
    <div>
        <a href="?export=csv" class="inline-flex items-center px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors text-sm font-semibold shadow-sm focus:ring-2 focus:ring-slate-200 focus:ring-offset-2">
            <i class="fa-solid fa-download mr-2"></i> Export List
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Resident</th>
                    <th class="px-6 py-4">Program/Year</th>
                    <th class="px-6 py-4">Dormitory</th>
                    <th class="px-6 py-4 text-center">Room</th>
                    <th class="px-6 py-4">Emergency Contact</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($residents)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fa-solid fa-users-slash text-slate-300 text-4xl mb-3 block"></i>
                            <span class="text-slate-500 font-medium">No residents found in your halls.</span>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($residents as $res): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs mr-3">
                                    <?php echo strtoupper(substr($res['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800"><?php echo htmlspecialchars($res['name']); ?></div>
                                    <div class="text-[11px] text-slate-500 mt-0.5 font-mono"><?php echo htmlspecialchars($res['student_id_number']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-700"><?php echo htmlspecialchars($res['course']); ?></div>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-adssu-light text-slate-600 border border-slate-200">
                                Year <?php echo htmlspecialchars($res['year_level']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">
                            <?php echo htmlspecialchars($res['dorm_name']); ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 border border-blue-100 font-mono text-xs font-bold">
                                <i class="fa-solid fa-door-closed mr-1.5 opacity-70"></i><?php echo htmlspecialchars($res['room_number']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-400 italic">Not specified</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/supervisor/incidents?student_id=<?php echo $res['student_id']; ?>" 
                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors shadow-sm border border-amber-100 hover:border-transparent" 
                               title="Log Incident">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
