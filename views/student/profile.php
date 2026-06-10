<?php include 'views/layouts/header.php'; ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">My Profile</h2>
    <p class="text-slate-500">Manage your personal information and view your ID pass.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: ID Pass -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center h-full">
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-adssu-green to-adssu-green_light flex items-center justify-center text-white font-bold text-4xl mb-4 shadow-lg shadow-adssu-green/20">
                    <?php echo strtoupper(substr($profile['name'] ?? $_SESSION['name'], 0, 1)); ?>
                </div>
                <h4 class="text-xl font-bold text-slate-800 mb-1"><?php echo htmlspecialchars($profile['name'] ?? $_SESSION['name']); ?></h4>
                <p class="text-slate-500 font-medium text-sm"><?php echo htmlspecialchars($profile['course'] ?? ''); ?></p>
                <span class="inline-block mt-3 px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold border border-slate-200">
                    Year <?php echo htmlspecialchars($profile['year_level'] ?? ''); ?>
                </span>
                
                <hr class="w-full my-6 border-slate-100">
                
                <h6 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Digital Resident Pass</h6>
                <div class="p-4 bg-slate-50 rounded-xl inline-block border border-slate-200 shadow-sm">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?php echo urlencode($profile['qr_code'] ?? ''); ?>" alt="QR Code" class="w-36 h-36 rounded-lg mx-auto">
                    <span class="block mt-3 font-mono text-xs font-bold text-slate-700"><?php echo htmlspecialchars($profile['qr_code'] ?? ''); ?></span>
                </div>
                <p class="text-xs text-slate-400 mt-4 leading-relaxed">Present this QR code to the gate guard or supervisor for scanning.</p>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Forms -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 h-full overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center">
                <i class="fa-solid fa-address-card text-adssu-green mr-3 text-lg"></i>
                <h5 class="text-lg font-bold text-slate-800">Personal Information</h5>
            </div>
            <div class="p-6 md:p-8">
                <?php if (!empty($success)): ?>
                    <div class="mb-6 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 flex items-start">
                        <i class="fa-solid fa-circle-check mt-1 mr-3"></i>
                        <div>
                            <strong class="block font-bold">Success</strong> 
                            <?php echo $success; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
                            <input type="text" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-100 text-slate-500 cursor-not-allowed" value="<?php echo htmlspecialchars($profile['name'] ?? $_SESSION['name']); ?>" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                            <input type="email" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-100 text-slate-500 cursor-not-allowed" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>" disabled>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Student ID Number</label>
                            <input type="text" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-100 text-slate-500 cursor-not-allowed" value="<?php echo htmlspecialchars($profile['student_id_number'] ?? ''); ?>" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Update Password</label>
                            <input type="password" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900" name="new_password" placeholder="Leave blank to keep current">
                        </div>
                    </div>
                    
                    <hr class="w-full my-8 border-slate-100">
                    
                    <div class="mb-6">
                        <h6 class="text-base font-bold text-slate-800 mb-1">Socio-Economic Data</h6>
                        <p class="text-xs text-slate-500 mb-4">Used for priority scoring during dormitory applications.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Income Bracket</label>
                            <select name="income_bracket" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900">
                                <option value="Low" <?php echo ($profile['income_bracket'] ?? 'Middle') == 'Low' ? 'selected' : ''; ?>>Low Income</option>
                                <option value="Middle" <?php echo ($profile['income_bracket'] ?? 'Middle') == 'Middle' ? 'selected' : ''; ?>>Middle Income</option>
                                <option value="High" <?php echo ($profile['income_bracket'] ?? 'Middle') == 'High' ? 'selected' : ''; ?>>High Income</option>
                            </select>
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-start cursor-pointer">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_indigenous" value="1" <?php echo (!empty($profile['is_indigenous'])) ? 'checked' : ''; ?> 
                                           class="w-5 h-5 text-adssu-green bg-white border-slate-300 rounded focus:ring-adssu-green focus:ring-2">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold text-slate-700">I am a member of an Indigenous Group</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button type="submit" class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-adssu-green hover:bg-adssu-green_light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-adssu-green transition-colors">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
