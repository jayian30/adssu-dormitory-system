<?php include 'views/layouts/header.php'; ?>

<div x-data="{ showModal: false }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manage Dormitories</h2>
            <p class="text-slate-500">View all halls, supervisors, and capacity status.</p>
        </div>
        <div>
            <button @click="showModal = true" class="inline-flex items-center px-4 py-2 bg-adssu-green text-white rounded-lg hover:bg-adssu-green_light transition-colors text-sm font-semibold shadow-sm focus:ring-2 focus:ring-adssu-green focus:ring-offset-2">
                <i class="fa-solid fa-plus mr-2"></i> Add Dormitory
            </button>
        </div>
    </div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Dormitory Name</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Supervisor</th>
                    <th class="px-6 py-4">Rooms</th>
                    <th class="px-6 py-4">Occupancy</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($dormitories)): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No dormitories found.</td></tr>
                <?php else: ?>
                    <?php foreach ($dormitories as $dorm): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 flex items-center">
                                <i class="fa-solid fa-building text-adssu-green mr-3 opacity-80"></i>
                                <?php echo htmlspecialchars($dorm['name']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest <?php echo strtolower($dorm['gender_type']) == 'male' ? 'bg-blue-100 text-blue-800' : (strtolower($dorm['gender_type']) == 'female' ? 'bg-pink-100 text-pink-800' : 'bg-purple-100 text-purple-800'); ?>">
                                <?php echo htmlspecialchars($dorm['gender_type']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-slate-600">
                                <i class="fa-solid fa-user-tie text-slate-400 mr-2"></i>
                                <?php echo htmlspecialchars($dorm['supervisor_name']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">
                            <?php echo $dorm['total_rooms'] ?? 0; ?> Rooms
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center w-48">
                                <?php 
                                $capacity = $dorm['capacity'] ?? 1; // avoid division by zero
                                $occupancy = $dorm['occupancy'] ?? 0;
                                $percent = min(100, round(($occupancy / $capacity) * 100)); 
                                $color = $percent >= 90 ? 'bg-red-500' : ($percent >= 70 ? 'bg-amber-500' : 'bg-emerald-500');
                                ?>
                                <div class="w-full bg-slate-200 rounded-full h-2 mr-3">
                                    <div class="<?php echo $color; ?> h-2 rounded-full" style="width: <?php echo $percent; ?>%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-600 w-10 text-right"><?php echo $occupancy; ?>/<?php echo $capacity; ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-adssu-green hover:border-adssu-green hover:bg-adssu-green/5 transition-colors mr-1" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-600 hover:bg-blue-50 transition-colors" title="View Rooms">
                                <i class="fa-solid fa-door-open"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- Add Dormitory Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/75" @click="showModal = false"></div>
            
            <div x-show="showModal" x-transition class="relative inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:max-w-lg sm:align-middle">
                <form method="POST">
                    <input type="hidden" name="action" value="add_dormitory">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Add New Dormitory</h3>
                        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-500">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Dormitory Name</label>
                            <input type="text" name="name" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Gender Type</label>
                                <select name="gender_type" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Co-ed">Co-ed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Total Capacity</label>
                                <input type="number" name="capacity" min="1" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Assign Supervisor</label>
                            <select name="supervisor_id" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                                <?php foreach ($supervisors as $sup): ?>
                                    <option value="<?php echo $sup['id']; ?>"><?php echo htmlspecialchars($sup['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-adssu-green rounded-lg hover:bg-adssu-green_light">Save Dormitory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div> <!-- End x-data wrapper -->

<?php include 'views/layouts/footer.php'; ?>
