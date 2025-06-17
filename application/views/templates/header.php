<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'User Management System'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --navbar-height: 60px;
        }
        
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding-top: var(--navbar-height);
            background-color: #f8f9fc;
            min-height: 100vh;
            position: relative;
        }

        /* Badge Styles */
        .badge {
            display: inline-flex !important;
            align-items: center;
            padding: 0.35em 0.65em;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.35rem;
            transition: none !important;
            opacity: 1 !important;
            position: static !important;
            z-index: auto !important;
        }

        .badge i {
            display: inline-block !important;
            margin-right: 0.5rem;
            font-size: inherit;
            line-height: inherit;
            vertical-align: middle;
        }

        /* Role Badge Specific Styles */
        .role-badge {
            font-size: 0.875rem;
            padding: 0.5em 0.85em;
            margin: 0 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .role-badge i {
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Remove Animations */
        .fade-in,
        .fade-out,
        .slide-in,
        .slide-out {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        /* Navbar Styles */
        .navbar {
            height: var(--navbar-height);
            background: linear-gradient(90deg, var(--primary-color) 0%, #224abe 100%) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: white !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            font-size: 1.4rem;
            margin-right: 0.5rem;
        }

        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            background-color: rgba(255,255,255,0.1);
            border-radius: 0.35rem;
        }

        .navbar-nav .nav-link i {
            width: 1.25rem;
            text-align: center;
            margin-right: 0.5rem;
            display: inline-flex;
            align-items: center;
        }

        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
            min-width: 200px;
        }

        .dropdown-menu.show {
            display: block;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        /* Search Form in Navbar */
        .navbar .form-control {
            background-color: rgba(255,255,255,0.1);
            border: none;
            color: white;
            padding-left: 1rem;
            padding-right: 1rem;
            border-radius: 2rem;
        }

        .navbar .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .navbar .form-control:focus {
            background-color: rgba(255,255,255,0.2);
            box-shadow: none;
        }

        .navbar .btn-light {
            border-radius: 2rem;
            padding: 0.375rem 1rem;
        }

        /* Ensure Proper Display in Navbar */
        .navbar .badge {
            display: inline-flex !important;
            align-items: center;
            margin-left: 0.5rem;
            position: relative;
            z-index: 1;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: linear-gradient(90deg, var(--primary-color) 0%, #224abe 100%);
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 0.5rem;
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 1rem;
            }

            .dropdown-menu {
                background-color: rgba(255,255,255,0.1);
                border: none;
                margin-left: 1rem;
                box-shadow: none;
            }

            .dropdown-menu.show {
                margin-top: 0;
            }

            .dropdown-item {
                color: rgba(255,255,255,0.9);
            }

            .dropdown-item:hover {
                background-color: rgba(255,255,255,0.2);
                color: white;
            }
        }
        
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding-top: 56px;
            background-color: #f8f9fc;
        }
        
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 10%, #224abe 100%);
            color: white;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            font-weight: 600;
            border-radius: 0.35rem;
        }
        
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            color: rgba(255, 255, 255, 0.3);
        }
        
        .sidebar .nav-link:hover i, .sidebar .nav-link.active i {
            color: white;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.2rem;
        }
        
        .topbar {
            height: 4.375rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background-color: white;
        }
        
        .content-wrapper {
            min-height: calc(100vh - 56px - 60px);
            padding: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        .btn {
            border-radius: 0.35rem;
            padding: 0.375rem 0.75rem;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-control {
            border-radius: 0.35rem;
        }
        
        .alert {
            border: none;
            border-radius: 0.35rem;
            border-left: 0.25rem solid;
        }
        
        .alert-success {
            border-left-color: var(--success-color);
        }
        
        .alert-danger {
            border-left-color: var(--danger-color);
        }
        
        .avatar {
            border-radius: 50%;
            height: 2rem;
            width: 2rem;
            object-fit: cover;
        }
        
        .dropdown-menu {
            font-size: 0.85rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
        }
        
        .dropdown-item i {
            margin-right: 0.5rem;
            color: var(--secondary-color);
        }
        
        .main-content {
            margin-top: 20px;
        }
        
        /* Animations for page transitions */
        .fade-in {
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* For mobile devices */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: static;
            }
        }

        /* Fixed Alert Container */
        .fixed-alert-container {
            position: fixed;
            top: 70px; /* Below navbar */
            right: 20px;
            z-index: 1050;
            max-width: 400px;
            min-width: 300px;
        }

        .alert {
            margin-bottom: 1rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.35rem;
            border-left: 0.25rem solid;
            opacity: 0;
            transform: translateX(100%);
            animation: slideIn 0.3s forwards;
        }

        .alert.fade-out {
            animation: slideOut 0.3s forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</head>
<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                <i class="fas fa-shield-alt"></i>
                <span>Auth System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="<?php echo base_url('Dashboard'); ?>">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <?php 
                        $permissions = $this->session->userdata('permissions');
                        if ($this->session->userdata('role_name') === 'Admin' ||
                            (is_array($permissions) && in_array('manage_users', $permissions))): ?>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="<?php echo base_url('Admin/users'); ?>">
                                    <i class="fas fa-users"></i>
                                    <span>Manage Users</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($this->session->userdata('role_name') === 'Admin' ||
                                (is_array($permissions) && in_array('manage_roles', $permissions))): ?>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="<?php echo base_url('Admin/roles'); ?>">
                                    <i class="fas fa-user-tag"></i>
                                    <span>Manage Roles</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <!-- Blog Links -->
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="<?php echo base_url('blog'); ?>">
                                <i class="fas fa-blog"></i>
                                <span>Blog</span>
                            </a>
                        </li>
                        <?php if ($this->session->userdata('role_name') === 'Admin' || 
                                  $this->session->userdata('role_name') === 'Editor'): ?>
                            <li class="nav-item dropdown">
                                <button class="nav-link dropdown-toggle btn btn-link" type="button" id="blogDropdown" 
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-edit"></i>
                                    <span>Manage Blog</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="blogDropdown">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url('admin/blog/posts'); ?>">
                                            <i class="fas fa-file-alt"></i>
                                            <span>Posts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url('admin/blog/create'); ?>">
                                            <i class="fas fa-plus"></i>
                                            <span>Create Post</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url('admin/blog/categories'); ?>">
                                            <i class="fas fa-tags"></i>
                                            <span>Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url('admin/blog/tags'); ?>">
                                            <i class="fas fa-hashtag"></i>
                                            <span>Tags</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="<?php echo base_url('blog'); ?>">
                                <i class="fas fa-blog"></i>
                                <span>Blog</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-2" action="<?= base_url('blog/search') ?>" method="get">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search blog..." 
                               value="<?= isset($search_query) ? htmlspecialchars($search_query) : '' ?>">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <li class="nav-item dropdown">
                            <button class="nav-link dropdown-toggle btn btn-link" type="button" id="userDropdown" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                <span class="mx-2"><?php echo $this->session->userdata('username'); ?></span>
                                <span class="badge bg-light text-primary"><?php echo $this->session->userdata('role_name'); ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url('User/profile'); ?>">
                                        <i class="fas fa-user"></i>
                                        <span>My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url('User/change_password'); ?>">
                                        <i class="fas fa-key"></i>
                                        <span>Change Password</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url('Auth/logout'); ?>">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="<?php echo base_url('Auth/login'); ?>">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Login</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="<?php echo base_url('Auth/register'); ?>">
                                <i class="fas fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Fixed Alert Container -->
    <div class="fixed-alert-container">
        <?php $this->load->view('templates/alerts'); ?>
    </div>

    <div class="container fade-in main-content">
        <!-- Content here -->
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap dropdowns
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownElementList.map(function(element) {
            return new bootstrap.Dropdown(element, {
                autoClose: true
            });
        });

        // Add click handlers to dropdown toggles
        document.querySelectorAll('.dropdown-toggle').forEach(function(dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var dropdown = bootstrap.Dropdown.getInstance(dropdownToggle);
                if (dropdown) {
                    dropdown.toggle();
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.matches('.dropdown-toggle') && !e.target.closest('.dropdown-menu')) {
                dropdownList.forEach(function(dropdown) {
                    dropdown.hide();
                });
            }
        });

        // Add active class to current nav item
        var currentPath = window.location.pathname;
        var navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        navLinks.forEach(function(link) {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
    </script>
</body>
</html>