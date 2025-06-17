<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-key me-2"></i>Change Password
        </h1>
        <a href="<?= base_url('User/profile'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> Back to Profile
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Your Password</h6>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); ?>
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i> Strong passwords should be at least 8 characters long and include a mix of uppercase letters, lowercase letters, numbers, and special characters.
                    </div>
                    
                    <?php echo form_open('User/change_password'); ?>
                        <div class="form-group mb-4">
                            <label for="current_password" class="form-label"><i class="fas fa-lock me-2"></i>Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control form-control-lg" required>
                            <small class="form-text text-muted">Enter your current password to verify your identity.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="new_password" class="form-label"><i class="fas fa-key me-2"></i>New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control form-control-lg" required>
                            <small class="form-text text-muted">Your new password must be at least 6 characters long.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="confirm_password" class="form-label"><i class="fas fa-check-circle me-2"></i>Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg" required>
                            <small class="form-text text-muted">Re-enter your new password to confirm.</small>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i> Update Password
                            </button>
                            <a href="<?= base_url('User/profile'); ?>" class="btn btn-light btn-lg">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Security Tips Card -->
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shield-alt fa-2x text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="text-warning">Password Security Tips</h5>
                            <ul class="mb-0">
                                <li>Never share your password with anyone</li>
                                <li>Use different passwords for different accounts</li>
                                <li>Avoid using common words or personal information</li>
                                <li>Change your passwords regularly</li>
                                <li>Consider using a password manager</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
    padding-left: 0.5rem;
}
</style> 