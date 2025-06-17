<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit User: <?= $user->username ?></h3>
                </div>
                <div class="card-body">
                    <?php echo form_open('Admin/edit_user/' . $user->id, ['id' => 'editUserForm']); ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= set_value('username', $user->username); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= set_value('email', $user->email); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (leave empty to keep current password)</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <small class="text-muted">Leave blank to keep current password</small>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <?php if ($user->id === $this->session->userdata('user_id') && $user->role_name === 'Admin'): ?>
                                <input type="text" class="form-control" value="Admin" disabled>
                                <input type="hidden" name="role_id" value="<?= $user->role_id ?>">
                                <small class="text-danger">You cannot change your own admin role</small>
                            <?php else: ?>
                                <select name="role_id" id="role_id" class="form-control" required 
                                        data-original-role="<?= $user->role_id ?>" 
                                        onchange="checkRoleChange(this)">
                                    <option value="">Select Role</option>
                                    <?php foreach($roles as $role): ?>
                                        <option value="<?= $role->id ?>" <?= set_select('role_id', $role->id, ($role->id == $user->role_id)); ?>>
                                            <?= $role->role_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mt-3">
                            <label for="active">Account Status</label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="1" <?= set_select('active', '1', ($user->active == 1)); ?>>Active</option>
                                <option value="0" <?= set_select('active', '0', ($user->active == 0)); ?>>Inactive</option>
                            </select>
                            <small class="text-muted">Inactive users will not be able to log in</small>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary" id="updateButton">Update User</button>
                            <a href="<?= base_url('Admin/users'); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                        <input type="hidden" name="confirm_password" id="confirmPasswordInput">
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Confirmation Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Confirm Your Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    You are about to change the user's role. Please confirm your password to proceed.
                </p>
                <div class="form-group">
                    <label for="confirmPassword">Your Password</label>
                    <input type="password" class="form-control" id="confirmPassword" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitWithPassword()">Confirm Change</button>
            </div>
        </div>
    </div>
</div>

<script>
let roleChanged = false;
const originalRole = document.querySelector('#role_id')?.dataset.originalRole;

function checkRoleChange(selectElement) {
    roleChanged = selectElement.value !== originalRole;
}

document.getElementById('editUserForm').addEventListener('submit', function(e) {
    if (roleChanged) {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    }
});

function submitWithPassword() {
    const password = document.getElementById('confirmPassword').value;
    if (!password) {
        alert('Please enter your password');
        return;
    }
    
    document.getElementById('confirmPasswordInput').value = password;
    document.getElementById('editUserForm').submit();
}
</script> 