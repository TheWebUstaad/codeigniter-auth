<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit User: <?= $user->username ?></h3>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                    
                    <?php echo form_open('Admin/edit_user/' . $user->id); ?>
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
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                <?php foreach($roles as $role): ?>
                                    <option value="<?= $role->id ?>" <?= set_select('role_id', $role->id, ($role->id == $user->role_id)); ?>>
                                        <?= $role->role_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="<?= base_url('Admin/users'); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 