<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'User Management System'; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { padding-top: 56px; }
        .wrapper { min-height: calc(100vh - 100px); } /* Adjust as needed */
        .footer { height: 60px; line-height: 60px; background-color: #f5f5f5; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">CI3 Multi-Role</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Dashboard'); ?>">Dashboard</a>
                    </li>
                    <?php 
                    $permissions = $this->session->userdata('permissions');
                    if ($this->session->userdata('role_name') === 'Admin' ||
                        (is_array($permissions) && in_array('manage_users', $permissions))): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('Admin/users'); ?>">Manage Users</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('role_name') === 'Admin' ||
                               (is_array($permissions) && in_array('manage_roles', $permissions))): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('Admin/roles'); ?>">Manage Roles</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <li class="nav-item">
                        <span class="nav-link">Welcome, <?php echo $this->session->userdata('username'); ?> (<?php echo $this->session->userdata('role_name'); ?>)</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Auth/logout'); ?>">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Auth/login'); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Auth/register'); ?>">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container wrapper mt-4">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>