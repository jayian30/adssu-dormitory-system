<?php include 'views/layouts/header.php'; ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Application Review</h2>
        <p class="text-slate-500">Evaluate dormitory applications and allocate priority scores.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Applicant</th>
                    <th class="px-6 py-4">Academic Info</th>
                    <th class="px-6 py-4">Socio-Economic</th>
                    <th class="px-6 py-4 text-center">Priority Score</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($applications)): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No applications found.</td></tr>
                <?php else: ?>
                    <?php foreach ($applications as $app): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-adssu-green text-white flex items-center justify-center font-bold text-sm mr-3 shadow-inner">
                                    <?php echo strtoupper(substr($app['student_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800"><?php echo htmlspecialchars($app['student_name']); ?></div>
                                    <div class="text-[11px] text-slate-500 mt-0.5 flex items-center">
                                        <i class="fa-regular fa-calendar mr-1"></i> <?php echo date('M d, Y', strtotime($app['created_at'])); ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-700"><?php echo htmlspecialchars($app['course']); ?></div>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                Year <?php echo htmlspecialchars($app['year_level']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1.5 items-start">
                                <?php if ($app['is_indigenous']): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        Indigenous
                                    </span>
                                <?php endif; ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                    <?php echo htmlspecialchars($app['income_bracket']); ?> Income
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-end justify-center">
                                <span class="text-xl font-extrabold text-adssu-green"><?php echo $app['priority_score']; ?></span>
                                <span class="text-[10px] font-bold text-slate-400 ml-1 mb-1 uppercase tracking-wider">pts</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if ($app['status'] == 'Approved'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-check-circle mr-1.5 opacity-70"></i> Approved
                                </span>
                            <?php elseif ($app['status'] == 'Pending'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-clock mr-1.5 opacity-70"></i> Pending
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-times-circle mr-1.5 opacity-70"></i> Rejected
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php if ($app['status'] == 'Pending'): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="approve">
                                    <input type="hidden" name="id" value="<?php echo $app['id']; ?>">
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-colors mr-1 shadow-sm border border-emerald-100 hover:border-transparent" title="Approve">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="reject">
                                    <input type="hidden" name="id" value="<?php echo $app['id']; ?>">
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors shadow-sm border border-red-100 hover:border-transparent" title="Reject">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <button class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 text-xs font-semibold cursor-not-allowed">
                                    Evaluated
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
