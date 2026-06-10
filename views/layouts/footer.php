<?php if (isset($_SESSION['user_id'])): ?>
            </main> <!-- End Main Content area -->
        </div> <!-- End Main Content Wrapper -->
    </div> <!-- End Sidebar Layout -->
<?php else: ?>
        </main> <!-- End Public Main Content -->
        
        <!-- Public Footer -->
        <footer class="bg-white border-t border-slate-200 py-6">
            <div class="text-center text-sm text-slate-500">
                &copy; <?php echo date('Y'); ?> ADSSU Dormitory Management System. All rights reserved.
            </div>
        </footer>
    </div> <!-- End Public Layout -->
<?php endif; ?>

</body>
</html>
