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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary py-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                <i class="fas fa-shield-alt me-2"></i>Auth System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('Dashboard'); ?>">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                        <?php 
                        $permissions = $this->session->userdata('permissions');
                        if ($this->session->userdata('role_name') === 'Admin' ||
                            (is_array($permissions) && in_array('manage_users', $permissions))): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('Admin/users'); ?>">
                                    <i class="fas fa-users me-1"></i> Manage Users
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($this->session->userdata('role_name') === 'Admin' ||
                                (is_array($permissions) && in_array('manage_roles', $permissions))): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('Admin/roles'); ?>">
                                    <i class="fas fa-user-tag me-1"></i> Manage Roles
                                </a>
                            </li>
                        <?php endif; ?>
                        <!-- Blog Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('blog'); ?>">
                                <i class="fas fa-blog me-1"></i> Blog
                            </a>
                        </li>
                        <?php if ($this->session->userdata('role_name') === 'Admin' || 
                                  $this->session->userdata('role_name') === 'Editor'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="blogDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-edit me-1"></i> Manage Blog
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="blogDropdown">
                                    <li><a class="dropdown-item" href="<?php echo base_url('admin/blog/posts'); ?>"><i class="fas fa-file-alt"></i> Posts</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('admin/blog/create'); ?>"><i class="fas fa-plus"></i> Create Post</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('admin/blog/categories'); ?>"><i class="fas fa-tags"></i> Categories</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('admin/blog/tags'); ?>"><i class="fas fa-hashtag"></i> Tags</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('blog'); ?>">
                                <i class="fas fa-blog me-1"></i> Blog
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                <?php echo $this->session->userdata('username'); ?>
                                <span class="badge bg-secondary"><?php echo $this->session->userdata('role_name'); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?php echo base_url('User/profile'); ?>"><i class="fas fa-user"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo base_url('User/change_password'); ?>"><i class="fas fa-key"></i> Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo base_url('Auth/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('Auth/login'); ?>">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('Auth/register'); ?>">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container fade-in main-content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>