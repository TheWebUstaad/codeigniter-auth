<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users me-2"></i>User Management</h1>
        <a href="<?= base_url('Admin/create_user'); ?>" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-user-plus me-1"></i> Add New User
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-1"></i> Export to Excel</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-1"></i> Export to PDF</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cogs me-1"></i> Other Actions</a></li>
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
                <table class="table table-bordered table-hover" id="userTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th><i class="fas fa-user me-1"></i> Username</th>
                            <th><i class="fas fa-envelope me-1"></i> Email</th>
                            <th class="text-center"><i class="fas fa-user-tag me-1"></i> Role</th>
                            <th class="text-center" style="width: 150px;"><i class="fas fa-cog me-1"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($users)): ?>
                            <?php $counter = 1; ?>
                            <?php foreach($users as $index => $user): ?>
                                <tr>
                                    <td class="text-center"><?= $counter++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 bg-primary rounded-circle text-center text-white" style="width: 32px; height: 32px; line-height: 32px;">
                                                <?= strtoupper(substr($user->username, 0, 1)); ?>
                                            </div>
                                            <?= $user->username; ?>
                                        </div>
                                    </td>
                                    <td><?= $user->email; ?></td>
                                    <td class="text-center">
                                        <?php 
                                        $badge_class = 'bg-primary';
                                        if ($user->role_name === 'Admin') $badge_class = 'bg-danger';
                                        elseif ($user->role_name === 'Editor') $badge_class = 'bg-success';
                                        elseif ($user->role_name === 'User') $badge_class = 'bg-info';
                                        ?>
                                        <span class="badge <?= $badge_class ?>"><?= $user->role_name; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('Admin/edit_user/' . $user->id); ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="View User">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($user->role_name !== 'Admin' || $this->session->userdata('user_id') != $user->id): ?>
                                            <a href="<?= base_url('Admin/delete_user/' . $user->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')" data-bs-toggle="tooltip" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> No users found
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