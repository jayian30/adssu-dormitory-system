<?php include 'views/layouts/header.php'; ?>

<div x-data="{ showModal: false }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Room Assignments</h2>
            <p class="text-slate-500">Manage active check-ins and room placements.</p>
        </div>
        <div>
            <button @click="showModal = true" class="inline-flex items-center px-4 py-2 bg-adssu-green text-white rounded-lg hover:bg-adssu-green_light transition-colors text-sm font-semibold shadow-sm focus:ring-2 focus:ring-adssu-green focus:ring-offset-2">
                <i class="fa-solid fa-plus mr-2"></i> Assign Room
            </button>
        </div>
    </div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Resident</th>
                    <th class="px-6 py-4">Dormitory</th>
                    <th class="px-6 py-4 text-center">Room</th>
                    <th class="px-6 py-4 text-center">Term</th>
                    <th class="px-6 py-4">Check-in Date</th>
                    <th class="px-6 py-4 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($assignments)): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No room assignments found.</td></tr>
                <?php else: ?>
                    <?php foreach ($assignments as $asn): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 flex items-center">
                                <i class="fa-regular fa-user text-adssu-green mr-3 opacity-80"></i>
                                <?php echo htmlspecialchars($asn['student_name']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-600">
                            <?php echo htmlspecialchars($asn['dorm_name']); ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-adssu-gold/10 text-adssu-gold_hover border border-adssu-gold/20 font-mono text-sm font-bold shadow-sm">
                                <i class="fa-solid fa-door-closed mr-2 opacity-70"></i> <?php echo htmlspecialchars($asn['room_number']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                <?php echo htmlspecialchars($asn['semester']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium">
                            <div class="flex items-center">
                                <i class="fa-regular fa-calendar mr-2 opacity-70"></i>
                                <?php echo date('M d, Y', strtotime($asn['check_in_date'])); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php if (empty($asn['check_out_date'])): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-check mr-1.5 opacity-70"></i> Active
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-door-open mr-1.5 opacity-70"></i> Checked Out
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

    <!-- Assign Room Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/75" @click="showModal = false"></div>
            
            <div x-show="showModal" x-transition class="relative inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:max-w-lg sm:align-middle">
                <form method="POST">
                    <input type="hidden" name="action" value="assign_room">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Assign Student to Room</h3>
                        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-500">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Select Student</label>
                            <select name="student_id" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                                <?php foreach ($students as $stu): ?>
                                    <option value="<?php echo $stu['id']; ?>"><?php echo htmlspecialchars($stu['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Select Available Room</label>
                            <select name="room_id" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                                <?php foreach ($rooms as $rm): ?>
                                    <option value="<?php echo $rm['id']; ?>"><?php echo htmlspecialchars($rm['dorm_name'] . ' - Room ' . $rm['room_number']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Semester / Term</label>
                                <input type="text" name="semester" required value="1st Semester 2024-2025" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Check-in Date</label>
                                <input type="date" name="check_in_date" required value="<?php echo date('Y-m-d'); ?>" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-adssu-green rounded-lg hover:bg-adssu-green_light">Assign Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div> <!-- End x-data wrapper -->

<?php include 'views/layouts/footer.php'; ?>
