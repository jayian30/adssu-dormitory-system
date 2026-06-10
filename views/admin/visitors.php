<?php include 'views/layouts/header.php'; ?>

<div x-data="{ showModal: false }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Visitor Logs</h2>
            <p class="text-slate-500">Monitor and register dormitory visitors.</p>
        </div>
        <div>
            <button @click="showModal = true" class="inline-flex items-center px-4 py-2 bg-adssu-green text-white rounded-lg hover:bg-adssu-green_light transition-colors text-sm font-semibold shadow-sm focus:ring-2 focus:ring-adssu-green focus:ring-offset-2">
                <i class="fa-solid fa-user-plus mr-2"></i> Register Visitor
            </button>
        </div>
    </div>

    <?php if (!empty($success)): ?>
        <div class="mb-6 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 flex items-start shadow-sm">
            <i class="fa-solid fa-circle-check mt-1 mr-3"></i>
            <div>
                <strong class="block font-bold">Success</strong> 
                <?php echo $success; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-800 flex items-start shadow-sm">
            <i class="fa-solid fa-triangle-exclamation mt-1 mr-3"></i>
            <div>
                <strong class="block font-bold">Error</strong> 
                <?php echo $error; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Visitor Name</th>
                        <th class="px-6 py-4">Relationship</th>
                        <th class="px-6 py-4">Resident Visited</th>
                        <th class="px-6 py-4">Date of Visit</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if(empty($visitors)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <i class="fa-solid fa-users-slash text-slate-300 text-4xl mb-3 block"></i>
                                <span class="text-slate-500 font-medium">No visitor logs found.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($visitors as $vis): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 flex items-center">
                                    <i class="fa-regular fa-user text-slate-400 mr-3"></i>
                                    <?php echo htmlspecialchars($vis['name']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                <?php echo htmlspecialchars($vis['relationship']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-800 font-semibold"><?php echo htmlspecialchars($vis['student_name']); ?></div>
                                <div class="text-xs text-slate-400">
                                    <?php echo !empty($vis['dorm_name']) ? htmlspecialchars($vis['dorm_name']) . ' - Room ' . htmlspecialchars($vis['room_number']) : 'No Room Assignment'; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-medium">
                                <div class="flex items-center text-xs">
                                    <i class="fa-regular fa-calendar mr-2 opacity-70"></i>
                                    <?php echo !empty($vis['check_in']) ? date('M d, Y h:i A', strtotime($vis['check_in'])) : 'Pending Check-in'; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if (!empty($vis['check_out'])): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800 uppercase tracking-widest border border-slate-200">
                                        <i class="fa-solid fa-clock-rotate-left mr-1.5 opacity-70"></i> Checked Out
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest border border-emerald-200">
                                        <i class="fa-solid fa-check mr-1.5 opacity-70"></i> Active
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <?php if (empty($vis['check_out'])): ?>
                                        <form method="POST" class="inline" onsubmit="return confirm('Check out this visitor?');">
                                            <input type="hidden" name="action" value="check_out">
                                            <input type="hidden" name="id" value="<?php echo $vis['id']; ?>">
                                            <button type="submit" class="inline-flex items-center justify-center px-2.5 py-1.5 rounded-lg border border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white transition-colors text-xs font-bold" title="Check Out">
                                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Check Out
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" class="inline" onsubmit="return confirm('Delete this visitor request?');">
                                        <input type="hidden" name="action" value="delete_visitor">
                                        <input type="hidden" name="id" value="<?php echo $vis['id']; ?>">
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-red-100 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors shadow-sm" title="Delete Log">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Register Visitor Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/75" @click="showModal = false"></div>
            
            <div x-show="showModal" x-transition class="relative inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:max-w-lg sm:align-middle">
                <form method="POST">
                    <input type="hidden" name="action" value="register_visitor">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Register New Visitor</h3>
                        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-500">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Resident to Visit</label>
                            <select name="student_id" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                                <option value="">-- Select Resident --</option>
                                <?php foreach ($residents as $res): ?>
                                    <option value="<?php echo $res['id']; ?>">
                                        <?php echo htmlspecialchars($res['name']); ?> (<?php echo htmlspecialchars($res['student_id_number']); ?>) - Room <?php echo htmlspecialchars($res['room_number']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Visitor Name</label>
                            <input type="text" name="name" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Relationship</label>
                            <select name="relationship" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                                <option value="Parent">Parent</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Relative">Relative</option>
                                <option value="Guardian">Guardian</option>
                                <option value="Friend">Friend</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-adssu-green rounded-lg hover:bg-adssu-green_light">Register Visitor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'views/layouts/footer.php'; ?>
