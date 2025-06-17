<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit me-2"></i>Update Profile
        </h1>
        <a href="<?= base_url('User/profile'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> Back to Profile
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Your Profile Information</h6>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); ?>
                    
                    <?php echo form_open('User/update_profile'); ?>
                        
                        <div class="mb-4 text-center">
                            <div class="avatar-xl mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 3rem;">
                                <?= strtoupper(substr($user->username, 0, 1)); ?>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="username" class="form-label"><i class="fas fa-user me-2"></i>Username</label>
                            <input type="text" name="username" id="username" class="form-control form-control-lg" value="<?= set_value('username', $user->username); ?>" required>
                            <small class="form-text text-muted">Your username must be unique and will be visible to other users.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" value="<?= set_value('email', $user->email); ?>" required>
                            <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label"><i class="fas fa-user-tag me-2"></i>Role</label>
                            <input type="text" class="form-control form-control-lg bg-light" value="<?= $user->role_name; ?>" disabled>
                            <small class="form-text text-muted">Your account role can only be changed by an administrator.</small>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                            <a href="<?= base_url('User/profile'); ?>" class="btn btn-light btn-lg">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Security Note Card -->
            <div class="card shadow mb-4 border-left-info">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle fa-2x text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="text-info">Want to update your password?</h5>
                            <p class="mb-0">
                                Your password can be changed separately from the profile information. 
                                <a href="<?= base_url('User/change_password'); ?>" class="font-weight-bold">Change your password</a>
                            </p>
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
}
</style> 