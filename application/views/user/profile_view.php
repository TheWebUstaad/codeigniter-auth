<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-circle me-2"></i>My Profile
        </h1>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-xl mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; font-size: 4rem;">
                            <?= strtoupper(substr($user->username, 0, 1)); ?>
                        </div>
                        <h4 class="mt-3"><?= $user->username ?></h4>
                        <p class="text-muted mb-1"><?= $user->email ?></p>
                        <span class="badge bg-<?php
                            switch($user->role_name) {
                                case 'Admin': echo 'danger'; break;
                                case 'Editor': echo 'success'; break;
                                default: echo 'info';
                            }
                        ?>">
                            <i class="fas fa-<?php
                                switch($user->role_name) {
                                    case 'Admin': echo 'user-shield'; break;
                                    case 'Editor': echo 'user-edit'; break;
                                    default: echo 'user';
                                }
                            ?> me-1"></i>
                            <?= $user->role_name ?>
                        </span>
                    </div>

                    <div class="list-group mb-4">
                        <div class="list-group-item border-0">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1"><i class="fas fa-user me-2"></i> Username</h6>
                                <span><?= $user->username ?></span>
                            </div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1"><i class="fas fa-envelope me-2"></i> Email</h6>
                                <span><?= $user->email ?></span>
                            </div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1"><i class="fas fa-user-tag me-2"></i> Role</h6>
                                <span><?= $user->role_name ?></span>
                            </div>
                        </div>
                    </div>

                    <a href="<?= base_url('User/update_profile'); ?>" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-user-edit me-2"></i> Edit Profile
                    </a>
                    <a href="<?= base_url('User/change_password'); ?>" class="btn btn-secondary w-100">
                        <i class="fas fa-key me-2"></i> Change Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Account Security Card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Security</h6>
                </div>
                <div class="card-body">
                    <div class="border-left-info pl-3 mb-4">
                        <h5 class="text-info"><i class="fas fa-lock me-2"></i> Password Security</h5>
                        <p>Ensure your account stays secure by following these password guidelines:</p>
                        <ul>
                            <li>Use a minimum of 8 characters</li>
                            <li>Include uppercase and lowercase letters</li>
                            <li>Add numbers and special characters</li>
                            <li>Avoid using easily guessable information like dates or names</li>
                        </ul>
                        <a href="<?= base_url('User/change_password'); ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-key me-1"></i> Change Password
                        </a>
                    </div>

                    <div class="border-left-warning pl-3 mb-4">
                        <h5 class="text-warning"><i class="fas fa-shield-alt me-2"></i> Account Protection</h5>
                        <p>Your account has standard security measures in place. Additional security features can be enabled for enhanced protection.</p>
                        <button class="btn btn-warning btn-sm" disabled>
                            <i class="fas fa-plus-circle me-1"></i> Enable Additional Security
                        </button>
                    </div>

                    <?php if ($user->role_name === 'Admin'): ?>
                    <div class="border-left-danger pl-3">
                        <h5 class="text-danger"><i class="fas fa-user-shield me-2"></i> Admin Privileges</h5>
                        <p>Your account has administrative privileges. With great power comes great responsibility.</p>
                        <a href="<?= base_url('Admin'); ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-cogs me-1"></i> Go to Admin Panel
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="fas fa-sign-in-alt me-2"></i> Last Login</h6>
                                <small><?= date('Y-m-d H:i:s') ?></small>
                            </div>
                            <p class="mb-1">Successful login from <span class="text-primary">127.0.0.1</span></p>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="fas fa-user-edit me-2"></i> Profile Updated</h6>
                                <small><?= date('Y-m-d', strtotime('-2 days')) ?></small>
                            </div>
                            <p class="mb-1">You updated your profile information</p>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="fas fa-key me-2"></i> Password Changed</h6>
                                <small><?= date('Y-m-d', strtotime('-7 days')) ?></small>
                            </div>
                            <p class="mb-1">You changed your password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
    padding-left: 1rem;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
    padding-left: 1rem;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
    padding-left: 1rem;
}
</style> 