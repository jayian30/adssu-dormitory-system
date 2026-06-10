<?php include 'views/layouts/header.php'; ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Admin Dashboard</h2>
    <p class="text-slate-500">Overview of dormitory operations and analytics.</p>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center transition-all duration-300 hover:shadow-md hover:-translate-y-1">
        <div class="w-14 h-14 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mr-4">
            <i class="fa-solid fa-building"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dormitories</p>
            <h3 class="text-2xl font-extrabold text-slate-800"><?php echo $stats['total_dorms']; ?></h3>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center transition-all duration-300 hover:shadow-md hover:-translate-y-1">
        <div class="w-14 h-14 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mr-4">
            <i class="fa-solid fa-bed"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Capacity</p>
            <h3 class="text-2xl font-extrabold text-slate-800"><?php echo $stats['total_capacity']; ?></h3>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center transition-all duration-300 hover:shadow-md hover:-translate-y-1">
        <div class="w-14 h-14 rounded-lg bg-adssu-gold/20 text-adssu-gold_hover flex items-center justify-center text-2xl mr-4">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Occupancy</p>
            <h3 class="text-2xl font-extrabold text-slate-800"><?php echo $stats['total_occupants']; ?></h3>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center transition-all duration-300 hover:shadow-md hover:-translate-y-1">
        <div class="w-14 h-14 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mr-4">
            <i class="fa-solid fa-file-signature"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Applications</p>
            <h3 class="text-2xl font-extrabold text-slate-800"><?php echo $stats['total_applications']; ?></h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Chart Column -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 h-full">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <i class="fa-solid fa-chart-pie text-adssu-green mr-2"></i> Occupancy by Dormitory
            </h3>
            <div style="position: relative; height:350px; width:100%">
                <canvas id="occupancyChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Action Items Column -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <i class="fa-solid fa-bell text-adssu-gold_hover mr-2"></i> Action Needed
            </h3>
            <ul class="space-y-4">
                <li class="flex items-center justify-between p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <div class="flex items-center text-amber-800">
                        <div class="w-8 h-8 rounded-full bg-amber-200 text-amber-600 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <span class="font-semibold text-sm">Pending Applications</span>
                    </div>
                    <span class="px-3 py-1 bg-amber-200 text-amber-900 rounded-full text-xs font-bold"><?php echo $action_items['pending_apps']; ?></span>
                </li>
                <li class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                    <div class="flex items-center text-red-800">
                        <div class="w-8 h-8 rounded-full bg-red-200 text-red-600 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <span class="font-semibold text-sm">Unpaid Fees</span>
                    </div>
                    <span class="px-3 py-1 bg-red-200 text-red-900 rounded-full text-xs font-bold"><?php echo $action_items['unpaid_fees']; ?></span>
                </li>
                <li class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="flex items-center text-blue-800">
                        <div class="w-8 h-8 rounded-full bg-blue-200 text-blue-600 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <span class="font-semibold text-sm">Incident Reports</span>
                    </div>
                    <span class="px-3 py-1 bg-blue-200 text-blue-900 rounded-full text-xs font-bold"><?php echo $action_items['pending_incidents']; ?></span>
                </li>
            </ul>
            <div class="mt-6">
                <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/admin/applications" class="flex justify-center items-center w-full py-2.5 bg-adssu-green text-white rounded-lg hover:bg-adssu-green_light transition-colors text-sm font-semibold shadow-sm">
                    Review Applications <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('occupancyChart').getContext('2d');
    const chartData = <?php echo json_encode($chart_data); ?>;
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Current Occupancy',
                    data: chartData.occupancy,
                    backgroundColor: '#064e3b',
                    borderRadius: 4
                },
                {
                    label: 'Remaining Capacity',
                    data: chartData.capacity.map((cap, i) => cap - chartData.occupancy[i]),
                    backgroundColor: '#e2e8f0',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, beginAtZero: true, grid: { color: '#f1f5f9' } }
            },
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });
});
</script>

<?php include 'views/layouts/footer.php'; ?>
