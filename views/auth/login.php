<?php include 'views/layouts/header.php'; ?>

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
    <div class="p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-adssu-green text-white mb-4 shadow-lg shadow-adssu-green/30">
                <i class="fa-solid fa-key text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-800">Welcome Back</h2>
            <p class="text-slate-500 mt-2">Sign in to manage your ADSSU dormitory account</p>
        </div>

        <?php if (isset($_GET['registered'])): ?>
            <div class="mb-6 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 flex items-start">
                <i class="fa-solid fa-circle-check mt-1 mr-3"></i>
                <div>
                    <strong class="block font-bold">Success!</strong> 
                    Registration completed! Please sign in.
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-800 flex items-start">
                <i class="fa-solid fa-circle-exclamation mt-1 mr-3"></i>
                <div>
                    <strong class="block font-bold">Error</strong>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-slate-400"></i>
                    </div>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required autofocus 
                           class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900" 
                           placeholder="student@adssu.edu.ph">
                </div>
            </div>
            
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input type="password" id="password" name="password" required 
                           class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-adssu-green focus:border-adssu-green transition-colors bg-slate-50 focus:bg-white text-slate-900" 
                           placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-adssu-green hover:bg-adssu-green_light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-adssu-green transition-colors">
                Sign In <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </form>
    </div>
    

</div>

<?php include 'views/layouts/footer.php'; ?>
