<?php include 'views/layouts/header.php'; ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Dormitory Application</h2>
    <p class="text-slate-500">Apply for a room in one of the ADSSU dormitory halls.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden max-w-2xl">
    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex items-center">
        <i class="fa-solid fa-file-signature text-adssu-green mr-3 text-lg"></i>
        <h5 class="text-lg font-bold text-slate-800">New Application Form</h5>
    </div>
    
    <div class="p-6 md:p-8">
        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-800 flex items-start">
                <i class="fa-solid fa-circle-exclamation mt-1 mr-3"></i>
                <div>
                    <strong class="block font-bold">Submission Failed</strong>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 flex items-start">
                <i class="fa-solid fa-circle-check mt-1 mr-3"></i>
                <div>
                    <strong class="block font-bold">Application Submitted</strong> 
                    <?php echo $success; ?>
                </div>
            </div>
        <?php else: ?>
        
            <form method="POST" action="" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Select Semester / Term</label>
                    <select name="semester" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-white text-slate-900" required>
                        <option value="1st Semester 2024-2025">1st Semester 2024-2025</option>
                        <option value="2nd Semester 2024-2025">2nd Semester 2024-2025</option>
                        <option value="Summer 2025">Summer 2025</option>
                    </select>
                </div>
                
                <div class="bg-adssu-light p-4 rounded-lg border border-slate-200">
                    <h6 class="text-sm font-bold text-slate-800 mb-2">Priority Scoring Information</h6>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Your application will be evaluated based on the socio-economic data you provided in your profile. 
                        Please ensure your profile is up to date before submitting.
                    </p>
                    <div class="mt-3 flex gap-2">
                        <a href="profile" class="text-xs font-bold text-adssu-green hover:text-adssu-gold_hover transition-colors">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Update Profile First
                        </a>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-adssu-green hover:bg-adssu-green_light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-adssu-green transition-colors">
                        Submit Application <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </div>
            </form>
            
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
