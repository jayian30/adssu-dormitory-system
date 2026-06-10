<?php include 'views/layouts/header.php'; ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Cleanliness Log</h2>
        <p class="text-slate-500">Record and monitor daily cleanliness inspections.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Log Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center">
                <i class="fa-solid fa-broom text-adssu-green mr-3"></i>
                <h3 class="font-bold text-slate-800">New Inspection</h3>
            </div>
            <div class="p-6">
                <?php if (isset($_GET['success'])): ?>
                    <div class="mb-6 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 flex items-start">
                        <i class="fa-solid fa-circle-check mt-1 mr-3"></i>
                        <div>
                            <strong class="block font-bold">Success</strong> 
                            Inspection logged successfully.
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Dormitory / Area</label>
                        <select name="dorm_id" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900">
                            <option value="">-- Select Area --</option>
                            <?php foreach ($managed_dorms as $dorm): ?>
                                <option value="<?php echo $dorm['id']; ?>"><?php echo htmlspecialchars($dorm['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Cleanliness Rating</label>
                        <select name="status" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900">
                            <option value="Excellent">Excellent</option>
                            <option value="Good" selected>Good</option>
                            <option value="Fair">Fair (Needs Minor Cleaning)</option>
                            <option value="Poor">Poor (Action Required)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Remarks</label>
                        <textarea name="remarks" rows="3" placeholder="Notes on specific areas (e.g., Hallway 2 needs mopping)" 
                                  class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900 resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-adssu-green hover:bg-adssu-green_light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-adssu-green transition-colors">
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
                <i class="fa-solid fa-clock-rotate-left text-adssu-green mr-3"></i>
                <h3 class="font-bold text-slate-800">Inspection History</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-white border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Area</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($cleanliness_logs)): ?>
                            <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No inspections logged yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($cleanliness_logs as $log): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-3 text-slate-500 font-medium text-xs">
                                    <div class="flex items-center">
                                        <i class="fa-regular fa-calendar mr-2 opacity-70"></i>
                                        <?php echo date('M d, Y', strtotime($log['log_date'])); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-bold text-slate-800">
                                    <?php echo htmlspecialchars($log['dorm_name']); ?>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <?php 
                                        $statusClass = 'bg-slate-100 text-slate-800';
                                        if ($log['status'] == 'Excellent') $statusClass = 'bg-emerald-100 text-emerald-800';
                                        elseif ($log['status'] == 'Good') $statusClass = 'bg-blue-100 text-blue-800';
                                        elseif ($log['status'] == 'Fair') $statusClass = 'bg-amber-100 text-amber-800';
                                        elseif ($log['status'] == 'Poor') $statusClass = 'bg-red-100 text-red-800';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest <?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($log['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-slate-600 text-xs truncate max-w-[200px]" title="<?php echo htmlspecialchars($log['remarks']); ?>">
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
