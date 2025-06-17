<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-1"></i> User Information
                    </h6>
                    <div>
                        <a href="<?= base_url('Admin/edit_user/' . $user->id); ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-edit me-1"></i> Edit User
                        </a>
                        <a href="<?= base_url('Admin/users'); ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-2 text-center">
                            <div class="avatar-lg mx-auto mb-2 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <span class="display-4 text-white"><?= strtoupper(substr($user->username, 0, 1)); ?></span>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h4><?= $user->username ?></h4>
                            <p class="text-muted mb-2">
                                <i class="fas fa-envelope me-2"></i> <?= $user->email ?>
                            </p>
                            <div class="mb-2">
                                <span class="badge bg-<?= $user->role_name === 'Admin' ? 'danger' : ($user->role_name === 'Editor' ? 'success' : 'info') ?> me-2">
                                    <i class="fas fa-user-tag me-1"></i> <?= $user->role_name ?>
                                </span>
                                <span class="badge <?= $user->active ? 'bg-success' : 'bg-warning' ?>">
                                    <i class="fas fa-circle me-1"></i> <?= $user->active ? 'Active' : 'Inactive' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">Account Information</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <strong>User ID:</strong> #<?= $user->id ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Created:</strong> <?= date('F j, Y', strtotime($user->created_at)) ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Last Updated:</strong> <?= date('F j, Y', strtotime($user->updated_at)) ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">Role & Permissions</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <strong>Role:</strong> <?= $user->role_name ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Status:</strong> 
                                            <?= $user->active ? '<span class="text-success">Active</span>' : '<span class="text-warning">Inactive</span>' ?>
                                        </li>
                                        <?php if(isset($user_permissions) && !empty($user_permissions)): ?>
                                        <li>
                                            <strong>Permissions:</strong><br>
                                            <?php foreach($user_permissions as $permission): ?>
                                                <span class="badge bg-secondary me-1 mb-1"><?= $permission ?></span>
                                            <?php endforeach; ?>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Recent Activity -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-1"></i> Recent Activity
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        <p>Activity tracking coming soon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 