<?php include 'views/layouts/header.php'; ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Incident Reports</h2>
        <p class="text-slate-500">Log violations, maintenance issues, or disciplinary actions.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Log Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-red-50 flex items-center">
                <i class="fa-solid fa-triangle-exclamation text-red-600 mr-3"></i>
                <h3 class="font-bold text-red-900">File New Incident</h3>
            </div>
            <div class="p-6">
                <?php if (isset($_GET['success'])): ?>
                    <div class="mb-6 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 flex items-start">
                        <i class="fa-solid fa-circle-check mt-1 mr-3"></i>
                        <div>
                            <strong class="block font-bold">Success</strong> 
                            Incident reported successfully.
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Involved Resident</label>
                        <select name="student_id" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors bg-white text-slate-900">
                            <option value="">-- Select Resident --</option>
                            <?php $pre_selected = $_GET['student_id'] ?? ''; ?>
                            <?php foreach ($residents as $res): ?>
                                <option value="<?php echo $res['id']; ?>" <?php echo $pre_selected == $res['id'] ? 'selected' : ''; ?>>
                                    Room <?php echo $res['room_number']; ?> - <?php echo htmlspecialchars($res['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Incident Type / Title</label>
                        <input type="text" name="title" required placeholder="e.g., Curfew Violation, Noise Complaint" 
                               class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors bg-white text-slate-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="4" required placeholder="Provide detailed information about what happened..." 
                                  class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors bg-white text-slate-900 resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition-colors">
                        Submit Report
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Past Logs -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden h-full">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center">
                <i class="fa-solid fa-folder-open text-adssu-green mr-3"></i>
                <h3 class="font-bold text-slate-800">Incident History</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-white border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Resident</th>
                            <th class="px-6 py-3">Incident</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($incident_logs)): ?>
                            <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No incidents reported yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($incident_logs as $log): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-3 text-slate-500 font-medium text-xs">
                                    <div class="flex items-center">
                                        <i class="fa-regular fa-calendar mr-2 opacity-70"></i>
                                        <?php echo date('M d, Y', strtotime($log['created_at'])); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-bold text-slate-800">
                                    <?php echo htmlspecialchars($log['student_name']); ?>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="font-bold text-slate-700 text-xs mb-0.5"><?php echo htmlspecialchars($log['title']); ?></div>
                                    <div class="text-slate-500 text-[10px] truncate max-w-[150px]" title="<?php echo htmlspecialchars($log['description']); ?>">
                                        <?php echo htmlspecialchars($log['description']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <?php if ($log['status'] == 'Resolved'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest">
                                            <i class="fa-solid fa-check mr-1.5 opacity-70"></i> Resolved
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 uppercase tracking-widest border border-amber-200">
                                            <i class="fa-solid fa-clock mr-1.5 opacity-70"></i> Pending
                                        </span>
                                    <?php endif; ?>
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
