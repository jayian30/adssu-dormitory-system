<?php include 'views/layouts/header.php'; ?>

<div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100 my-8">
    <div class="p-8 md:p-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-slate-800">Create an Account</h2>
            <p class="text-slate-500 mt-2">Register to apply for ADSSU dormitory accommodation</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-800 flex items-start">
                <i class="fa-solid fa-circle-exclamation mt-1 mr-3"></i>
                <div>
                    <strong class="block font-bold">Registration Failed</strong>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Left Column -->
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required 
                               class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900" 
                               placeholder="Juan Dela Cruz">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required 
                               class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900" 
                               placeholder="juan@student.adssu.edu.ph">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" required 
                               class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900" 
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Student ID Number</label>
                        <input type="text" name="student_id_number" value="<?php echo htmlspecialchars($student_id_number ?? ''); ?>" required 
                               class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900" 
                               placeholder="2024-XXXX">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Course / Program</label>
                        <input type="text" name="course" value="<?php echo htmlspecialchars($course ?? ''); ?>" required 
                               class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900" 
                               placeholder="BS Information Technology">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Year Level</label>
                            <select name="year_level" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900">
                                <option value="1" <?php echo ($year_level ?? 1) == 1 ? 'selected' : ''; ?>>1st Year</option>
                                <option value="2" <?php echo ($year_level ?? 1) == 2 ? 'selected' : ''; ?>>2nd Year</option>
                                <option value="3" <?php echo ($year_level ?? 1) == 3 ? 'selected' : ''; ?>>3rd Year</option>
                                <option value="4" <?php echo ($year_level ?? 1) == 4 ? 'selected' : ''; ?>>4th Year</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Income Bracket</label>
                            <select name="income_bracket" class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900">
                                <option value="Low" <?php echo ($income_bracket ?? 'Middle') == 'Low' ? 'selected' : ''; ?>>Low Income</option>
                                <option value="Middle" <?php echo ($income_bracket ?? 'Middle') == 'Middle' ? 'selected' : ''; ?>>Middle Income</option>
                                <option value="High" <?php echo ($income_bracket ?? 'Middle') == 'High' ? 'selected' : ''; ?>>High Income</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8 p-4 bg-slate-50 rounded-lg border border-slate-200">
                <label class="flex items-start cursor-pointer">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_indigenous" value="1" <?php echo !empty($is_indigenous) ? 'checked' : ''; ?> 
                               class="w-5 h-5 text-adssu-green bg-white border-slate-300 rounded focus:ring-adssu-green focus:ring-2">
                    </div>
                    <div class="ml-3 text-sm">
                        <span class="font-bold text-slate-700">I am a member of an Indigenous Group</span>
                        <p class="text-slate-500 font-normal">This information is used for priority scoring during dormitory application evaluation.</p>
                    </div>
                </label>
            </div>

            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-base font-bold text-white bg-adssu-green hover:bg-adssu-green_light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-adssu-green transition-colors">
                Create Account
            </button>
        </form>
    </div>
    
    <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 text-center">
        <p class="text-sm text-slate-600">
            Already have an account? 
            <a href="login" class="font-bold text-adssu-green hover:text-adssu-gold transition-colors">Sign in here</a>
        </p>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
