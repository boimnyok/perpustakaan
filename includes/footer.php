    </div> <!-- End of #content -->

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const body = document.body;
            
            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (window.innerWidth < 768) {
                    // Mobile view - toggle overlay
                    body.classList.toggle('sidebar-mobile-show');
                } else {
                    // Desktop view - toggle sidebar
                    body.classList.toggle('sidebar-collapsed');
                }
            });
            
            // Close sidebar when clicking on overlay (mobile)
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 768 && 
                    body.classList.contains('sidebar-mobile-show') &&
                    !e.target.closest('#sidebar') && 
                    e.target.id !== 'sidebarToggle') {
                    body.classList.remove('sidebar-mobile-show');
                }
            });
            
            // Highlight active menu item
            const currentPage = '<?php echo basename($_SERVER["PHP_SELF"]); ?>';
            const currentDir = '<?php echo basename(dirname($_SERVER["PHP_SELF"])); ?>';
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href.includes(currentPage) && href.includes(currentDir)) {
                    link.classList.add('active');
                }
            });
            
            // Prevent closing when clicking inside sidebar
            document.getElementById('sidebar').addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>