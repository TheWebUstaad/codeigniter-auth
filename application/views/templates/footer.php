    </div> <!-- End of container -->
    
    <footer class="footer py-4 bg-dark text-white mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <span>&copy; <?php echo date('Y'); ?> Auth System</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="social-icons">
                        <a href="#" class="mx-1"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="mx-1"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="mx-1"><i class="fab fa-github"></i></a>
                        <a href="#" class="mx-1"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle active class in navmenu
        const currentLocation = location.href;
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            if (link.href === currentLocation) {
                link.classList.add('active');
            }
        });
        
        // Enable tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        
        // Enable popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        popoverTriggerList.map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
    });
    </script>
</body>
</html>