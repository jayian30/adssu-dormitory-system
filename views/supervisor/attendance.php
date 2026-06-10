<?php include 'views/layouts/header.php'; ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Attendance Log</h2>
        <p class="text-slate-500">Track and monitor resident attendance and curfew.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Log Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center">
                <i class="fa-solid fa-clipboard-user text-adssu-green mr-3"></i>
                <h3 class="font-bold text-slate-800">Log New Entry</h3>
            </div>
            <div class="p-6">
                <?php if (isset($_GET['success'])): ?>
                    <div class="mb-6 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 flex items-start">
                        <i class="fa-solid fa-circle-check mt-1 mr-3"></i>
                        <div>
                            <strong class="block font-bold">Success</strong> 
                            Attendance logged successfully.
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Select Resident</label>
                        <select name="student_id" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900">
                            <option value="">-- Choose Resident --</option>
                            <?php foreach ($residents as $res): ?>
                                <option value="<?php echo $res['id']; ?>">Room <?php echo $res['room_number']; ?> - <?php echo htmlspecialchars($res['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-center px-3 py-2 border border-slate-200 rounded-lg cursor-pointer hover:bg-emerald-50 hover:border-emerald-200 transition-colors bg-white group">
                                <input type="radio" name="status" value="Present" required class="sr-only peer">
                                <span class="peer-checked:text-emerald-600 peer-checked:font-bold text-slate-600 font-medium">Present</span>
                            </label>
                            <label class="flex items-center justify-center px-3 py-2 border border-slate-200 rounded-lg cursor-pointer hover:bg-red-50 hover:border-red-200 transition-colors bg-white group">
                                <input type="radio" name="status" value="Absent" class="sr-only peer">
                                <span class="peer-checked:text-red-600 peer-checked:font-bold text-slate-600 font-medium">Absent (Curfew)</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Remarks (Optional)</label>
                        <input type="text" name="remarks" placeholder="e.g., Late arrival, Valid excuse" 
                               class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900">
                    </div>
                    <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-adssu-green hover:bg-adssu-green_light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-adssu-green transition-colors">
                        Save Log Entry
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Today's Logs -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden h-full">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fa-solid fa-list-check text-adssu-green mr-3"></i>
                    <h3 class="font-bold text-slate-800">Today's Logs</h3>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-200 px-2 py-1 rounded-md"><?php echo date('M d, Y', strtotime($today)); ?></span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-white border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-3">Time</th>
                            <th class="px-6 py-3">Resident</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($attendance_logs)): ?>
                            <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No attendance logged today.</td></tr>
                        <?php else: ?>
                            <?php foreach ($attendance_logs as $log): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-3 text-slate-500 font-medium text-xs">
                                    <div class="flex items-center">
                                        <i class="fa-regular fa-clock mr-2 opacity-70"></i>
                                        <?php echo date('h:i A', strtotime($log['created_at'])); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-bold text-slate-800">
                                    <?php echo htmlspecialchars($log['student_name']); ?>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <?php if ($log['status'] == 'Present'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest">
                                            Present
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-widest">
                                            Absent
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-3 text-slate-600 text-xs truncate max-w-[150px]" title="<?php echo htmlspecialchars($log['remarks']); ?>">
                                    <?php echo htmlspecialchars($log['remarks']) ?: '-'; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
