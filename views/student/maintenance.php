<?php include 'views/layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
        <div>
            <h2 class="fw-bold text-primary" style="letter-spacing: -0.03em;">Maintenance Tickets</h2>
            <p class="text-muted">Submit facility repair requests or track ticket resolution status.</p>
        </div>
        <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/student/dashboard" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>
</div>

<div class="row g-4">
    <!-- Log Ticket Form -->
    <div class="col-lg-5">
        <div class="card p-4 shadow-sm border-0" style="border-radius: 16px;">
            <h5 class="mb-4 text-primary fw-bold border-bottom pb-2">Log Issue Ticket</h5>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-left: 4px solid var(--danger-color); background-color: var(--danger-soft); color: #991b1b;">
                    <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-left: 4px solid var(--accent-color); background-color: var(--accent-soft); color: #065f46;">
                    <strong>Success!</strong> <?php echo htmlspecialchars($success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Issue Summary / Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Broken bathroom light, water leak..." required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Problem Description / Details</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Provide complete details about the issue..." required></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="photo" class="form-label fw-bold">Upload Photo Proof (Optional)</label>
                    <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary py-3 fw-bold rounded-pill">Submit Maintenance Ticket</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Tickets List -->
    <div class="col-lg-7">
        <div class="card p-4 shadow-sm border-0" style="border-radius: 16px;">
            <h5 class="mb-4 text-primary fw-bold border-bottom pb-2">Ticket History Logs</h5>
            
            <?php if (empty($tickets)): ?>
                <div class="text-center py-5">
                    <p class="text-muted mb-0">No past maintenance tickets filed.</p>
                </div>
            <?php else: ?>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($tickets as $t): ?>
                        <div class="p-3 rounded-3 bg-light border d-flex flex-column flex-sm-row justify-content-between gap-3">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h6 class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($t['issue_title']); ?></h6>
                                    <span class="badge <?php 
                                        if ($t['status'] == 'Resolved') echo 'bg-success';
                                        elseif ($t['status'] == 'Assigned') echo 'bg-info';
                                        else echo 'bg-warning text-dark'; 
                                    ?>">
                                        <?php echo htmlspecialchars($t['status']); ?>
                                    </span>
                                </div>
                                <p class="small text-muted mb-2"><?php echo htmlspecialchars($t['description']); ?></p>
                                
                                <?php if ($t['assigned_staff']): ?>
                                    <small class="d-block text-primary fw-semibold mb-1">🛠️ Assigned Staff: <?php echo htmlspecialchars($t['assigned_staff']); ?></small>
                                <?php endif; ?>
                                
                                <small class="text-muted d-block" style="font-size: 0.75rem;">📅 Filed: <?php echo date('M d, Y H:i', strtotime($t['created_at'])); ?></small>
                            </div>
                            
                            <?php if ($t['photo_path']): ?>
                                <div class="text-center text-sm-end">
                                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/assets/uploads/<?php echo $t['photo_path']; ?>" target="_blank">
                                        <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/assets/uploads/<?php echo $t['photo_path']; ?>" alt="Issue photo" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
