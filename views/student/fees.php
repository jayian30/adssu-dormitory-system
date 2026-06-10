<?php include 'views/layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
        <div>
            <h2 class="fw-bold text-primary" style="letter-spacing: -0.03em;">Fees & Payments</h2>
            <p class="text-muted">Track your dormitory fee records and transaction ledger history.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print();" class="btn btn-outline-primary shadow-sm d-flex align-items-center gap-1 fw-bold">
                🖨️ Print Statement
            </button>
            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/student/dashboard" class="btn btn-outline-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card p-4">
            <h5 class="mb-4 text-primary fw-bold border-bottom pb-2">Student Ledger Accounts</h5>
            
            <?php if (empty($fees)): ?>
                <div class="text-center py-5">
                    <p class="text-muted mb-0">You currently have no recorded fees or payment history logs.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Payment Status</th>
                                <th>Settlement Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_unpaid = 0;
                            foreach ($fees as $fee): 
                                if ($fee['status'] == 'Unpaid') $total_unpaid += $fee['amount'];
                            ?>
                            <tr>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($fee['description']); ?></td>
                                <td class="fw-semibold">₱<?php echo number_format($fee['amount'], 2); ?></td>
                                <td class="text-muted fw-medium"><?php echo date('M d, Y', strtotime($fee['due_date'])); ?></td>
                                <td>
                                    <?php if ($fee['status'] == 'Paid'): ?>
                                        <span class="badge badge-soft-success">Paid</span>
                                    <?php else: ?>
                                        <span class="badge badge-soft-danger">Unpaid</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small">
                                    <?php echo $fee['paid_date'] ? date('M d, Y', strtotime($fee['paid_date'])) : '-'; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <?php if ($total_unpaid > 0): ?>
                        <tfoot>
                            <tr style="background-color: #fef3c7;">
                                <td class="fw-bold text-end text-dark" style="border: none;">Total Outstanding Balance:</td>
                                <td class="fw-bold text-danger" style="border: none; font-size: 1.1rem;">₱<?php echo number_format($total_unpaid, 2); ?></td>
                                <td colspan="3" style="border: none;"></td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
                
                <div class="alert alert-warning mt-4 d-flex align-items-start gap-3 border-0 shadow-sm" style="border-left: 4px solid var(--warning-color); background-color: var(--warning-soft); color: #92400e; padding: 20px;">
                    <span class="fs-4" style="line-height: 1;">💡</span>
                    <div>
                        <strong class="d-block mb-1" style="font-size: 0.95rem;">Payment Settle Instructions</strong>
                        Please proceed directly to the ADSSU Cashier's Office to clear outstanding balances. Remember to present your official student registration form and Student ID to the attending teller.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
