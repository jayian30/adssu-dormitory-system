<?php include 'views/layouts/header.php'; ?>

<div x-data="{ showModal: false }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">System Announcements</h2>
            <p class="text-slate-500">Broadcast messages to students and supervisors.</p>
        </div>
        <div>
            <button @click="showModal = true" class="inline-flex items-center px-4 py-2 bg-adssu-green text-white rounded-lg hover:bg-adssu-green_light transition-colors text-sm font-semibold shadow-sm focus:ring-2 focus:ring-adssu-green focus:ring-offset-2">
                <i class="fa-solid fa-bullhorn mr-2"></i> Post Announcement
            </button>
        </div>
    </div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4 w-1/4">Title</th>
                    <th class="px-6 py-4 w-1/3">Message Preview</th>
                    <th class="px-6 py-4">Posted By</th>
                    <th class="px-6 py-4">Date Posted</th>
                    <th class="px-6 py-4 text-center">Priority</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(empty($announcements)): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No announcements posted.</td></tr>
                <?php else: ?>
                    <?php foreach ($announcements as $ann): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 whitespace-normal line-clamp-2">
                                <?php echo htmlspecialchars($ann['title']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-500 max-w-xs truncate" title="<?php echo htmlspecialchars($ann['content']); ?>">
                                <?php echo htmlspecialchars($ann['content']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-slate-600 font-medium">
                                <i class="fa-solid fa-user-tie text-slate-400 mr-2"></i>
                                <?php echo htmlspecialchars($ann['author_name']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            <div class="flex items-center">
                                <i class="fa-regular fa-clock mr-2 opacity-70"></i>
                                <?php echo date('M d, Y H:i', strtotime($ann['created_at'])); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if ($ann['is_emergency']): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-widest border border-red-200">
                                    <i class="fa-solid fa-triangle-exclamation mr-1.5 opacity-70"></i> Emergency
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 uppercase tracking-widest border border-blue-100">
                                    General
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $ann['id']; ?>">
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors shadow-sm border border-red-100 hover:border-transparent" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- Post Announcement Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/75" @click="showModal = false"></div>
            
            <div x-show="showModal" x-transition class="relative inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:max-w-lg sm:align-middle">
                <form method="POST">
                    <input type="hidden" name="action" value="post_announcement">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Post New Announcement</h3>
                        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-500">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                            <input type="text" name="title" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Content</label>
                            <textarea name="content" required rows="4" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green"></textarea>
                        </div>
                        <div class="flex items-center mt-2">
                            <input type="checkbox" name="is_emergency" value="1" class="w-4 h-4 text-red-600 border-slate-300 rounded focus:ring-red-500">
                            <label class="ml-2 block text-sm font-semibold text-red-700">Mark as Emergency (Urgent)</label>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-adssu-green rounded-lg hover:bg-adssu-green_light">Post Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div> <!-- End x-data wrapper -->

<?php include 'views/layouts/footer.php'; ?>
