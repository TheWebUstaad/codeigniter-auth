<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
        </h1>
        <?php if ($this->session->userdata('role_name') === 'Admin'): ?>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50 me-1"></i> Generate Report
            </a>
        <?php endif; ?>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= isset($user_count) ? $user_count : '10' ?>
                            </div>
                            <div class="small text-success mt-1">
                                <i class="fas fa-arrow-up"></i> 12% increase
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Roles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= isset($role_count) ? $role_count : '3' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Permissions
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        <?= isset($permission_count) ? $permission_count : '5' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-key fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Security Status</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Good</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Main Management Cards -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">User Management</h6>
                    <a href="<?= base_url('Admin/users'); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" 
                            src="https://cdni.iconscout.com/illustration/premium/thumb/user-management-3462294-2895932.png" alt="User Management">
                    </div>
                    <p>The User Management module allows administrators to create, edit, and delete user accounts. You can assign roles to users and manage their permissions.</p>
                    <div class="d-grid">
                        <a href="<?= base_url('Admin/users'); ?>" class="btn btn-primary">
                            <i class="fas fa-users me-1"></i> Manage Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Role Management</h6>
                    <a href="<?= base_url('Admin/roles'); ?>" class="btn btn-sm btn-success">View All</a>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" 
                            src="https://cdni.iconscout.com/illustration/premium/thumb/role-based-access-control-3462297-2895935.png" alt="Role Management">
                    </div>
                    <p>The Role Management module allows administrators to create, edit, and delete user roles. You can define permissions for each role to control access to system features.</p>
                    <div class="d-grid">
                        <a href="<?= base_url('Admin/roles'); ?>" class="btn btn-success">
                            <i class="fas fa-user-tag me-1"></i> Manage Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($this->session->userdata('role_name') === 'Admin'): ?>
    <!-- System Analytics - Only visible to Admin role -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>System Analytics
                    </h6>
                    <span class="badge bg-primary ms-2">Admin Only</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- System Information -->
                        <div class="col-md-4">
                            <h6 class="text-gray-600 border-bottom pb-2 mb-3">System Information</h6>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-server me-2"></i>System Version</p>
                                <strong class="text-dark">1.0.0</strong>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-code me-2"></i>Framework</p>
                                <strong class="text-dark">CodeIgniter <?= CI_VERSION ?></strong>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-database me-2"></i>Database</p>
                                <strong class="text-dark"><?= $this->db->platform() . ' ' . $this->db->version() ?></strong>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fab fa-php me-2"></i>PHP Version</p>
                                <strong class="text-dark"><?= PHP_VERSION ?></strong>
                            </div>
                        </div>
                        
                        <!-- Performance Metrics -->
                        <div class="col-md-4">
                            <h6 class="text-gray-600 border-bottom pb-2 mb-3">Performance Metrics</h6>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-tachometer-alt me-2"></i>Memory Usage</p>
                                <strong class="text-dark"><?= round(memory_get_usage() / 1048576, 2) ?> MB</strong>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-clock me-2"></i>Load Time</p>
                                <strong class="text-dark"><?= round(microtime(true) - ENVIRONMENT_START, 4) ?> seconds</strong>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-database me-2"></i>Database Queries</p>
                                <strong class="text-dark"><?= $this->db->query_count ?></strong>
                            </div>
                        </div>
                        
                        <!-- Security Status -->
                        <div class="col-md-4">
                            <h6 class="text-gray-600 border-bottom pb-2 mb-3">Security Status</h6>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-shield-alt me-2"></i>SSL Status</p>
                                <strong class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>Active
                                </strong>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-lock me-2"></i>Last Security Scan</p>
                                <strong class="text-dark">
                                    <?= date('Y-m-d H:i:s') ?>
                                </strong>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-user-shield me-2"></i>Security Level</p>
                                <strong class="text-success">High</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.card-header {
    background-color: #f8f9fc;
}
.border-left-primary {
    border-left: 0.25rem solid #4e73df!important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a!important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc!important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e!important;
}
.badge {
    padding: 0.5em 0.8em;
    font-weight: 500;
}
.text-success {
    color: #1cc88a!important;
}
</style> 