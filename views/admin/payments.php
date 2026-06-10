<?php include 'views/layouts/header.php'; ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Payment Records</h2>
        <p class="text-slate-500">Track dormitory fees and generate invoices.</p>
    </div>
    <div>
        <button class="inline-flex items-center px-4 py-2 bg-adssu-green text-white rounded-lg hover:bg-adssu-green_light transition-colors text-sm font-semibold shadow-sm focus:ring-2 focus:ring-adssu-green focus:ring-offset-2">
            <i class="fa-solid fa-file-invoice-dollar mr-2"></i> Add Fee Invoice
        </button>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Resident</th>
                    <th class="px-6 py-4">Description</th>
                    <th class="px-6 py-4 text-right">Amount</th>
                    <th class="px-6 py-4 text-center">Due Date</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($payments)): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No payment records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($payments as $pay): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 flex items-center">
                                <i class="fa-solid fa-user-graduate text-slate-400 mr-3"></i>
                                <?php echo htmlspecialchars($pay['student_name']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <?php echo htmlspecialchars($pay['description']); ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-lg font-bold text-adssu-green">₱<?php echo number_format($pay['amount'], 2); ?></span>
                        </td>
                        <td class="px-6 py-4 text-center text-slate-500 font-medium">
                            <div class="flex items-center justify-center">
                                <i class="fa-regular fa-calendar mr-2 opacity-70"></i>
                                <?php echo date('M d, Y', strtotime($pay['due_date'])); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if ($pay['status'] == 'Paid'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-check mr-1.5 opacity-70"></i> Paid
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-clock mr-1.5 opacity-70"></i> Unpaid
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php if ($pay['status'] == 'Unpaid'): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="mark_paid">
                                    <input type="hidden" name="id" value="<?php echo $pay['id']; ?>">
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-colors shadow-sm border border-emerald-100 hover:border-transparent" title="Mark as Paid">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <button onclick="window.print()" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-adssu-green hover:border-adssu-green hover:bg-adssu-green/5 transition-colors" title="Print Receipt">
                                    <i class="fa-solid fa-print"></i>
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
