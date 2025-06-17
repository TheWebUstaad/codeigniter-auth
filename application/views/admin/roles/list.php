<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-tag me-2"></i>Role Management</h1>
        <a href="<?= base_url('Admin/create_role'); ?>" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Add New Role
        </a>
    </div>

    <div class="row">
        <!-- Role Statistics Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Roles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($roles); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users with Admin Role -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Admin Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                    $admin_count = 0;
                                    foreach ($roles as $role) {
                                        if ($role->role_name === 'Admin') {
                                            // Ideally, you would have a count of users per role
                                            $admin_count = 1; // Placeholder value
                                            break;
                                        }
                                    }
                                    echo $admin_count;
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Roles</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-1"></i> Export to Excel</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-1"></i> Export to PDF</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
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
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="rolesTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th><i class="fas fa-tag me-1"></i> Role Name</th>
                            <th><i class="fas fa-info-circle me-1"></i> Description</th>
                            <th class="text-center" style="width: 150px;"><i class="fas fa-cog me-1"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($roles)): ?>
                            <?php foreach($roles as $role): ?>
                                <tr>
                                    <td class="text-center"><?= $role->id; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php
                                            $icon_class = 'fas fa-user';
                                            $badge_class = 'bg-primary';
                                            if ($role->role_name === 'Admin') {
                                                $icon_class = 'fas fa-user-shield';
                                                $badge_class = 'bg-danger';
                                            } elseif ($role->role_name === 'Editor') {
                                                $icon_class = 'fas fa-user-edit';
                                                $badge_class = 'bg-success';
                                            } elseif ($role->role_name === 'User') {
                                                $icon_class = 'fas fa-user';
                                                $badge_class = 'bg-info';
                                            }
                                            ?>
                                            <div class="avatar-sm me-3 <?= $badge_class ?> rounded-circle text-center text-white" style="width: 32px; height: 32px; line-height: 32px;">
                                                <i class="<?= $icon_class ?>"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold"><?= $role->role_name; ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $role->description ?? 'N/A'; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('Admin/edit_role/' . $role->id); ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if($role->role_name !== 'Admin'): // Prevent deleting the Admin role ?>
                                            <a href="<?= base_url('Admin/delete_role/' . $role->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this role?')" data-bs-toggle="tooltip" title="Delete Role">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-3">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> No roles found
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script> 