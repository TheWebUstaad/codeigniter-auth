<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Role: <?= $role->role_name ?></h3>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                    
                    <?php echo form_open('Admin/edit_role/' . $role->id); ?>
                        <div class="form-group mb-3">
                            <label for="role_name">Role Name</label>
                            <input type="text" name="role_name" id="role_name" class="form-control" value="<?= set_value('role_name', $role->role_name); ?>" required <?= ($role->role_name === 'Admin') ? 'readonly' : ''; ?>>
                            <?php if($role->role_name === 'Admin'): ?>
                                <small class="text-muted">Admin role name cannot be changed.</small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3"><?= set_value('description', $role->description); ?></textarea>
                        </div>
                        
                        <?php if(isset($permissions) && !empty($permissions)): ?>
                            <div class="form-group mt-4">
                                <h4>Permissions</h4>
                                
                                <?php if($role->role_name === 'Admin'): ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Admin role has all permissions by default.
                                    </div>
                                <?php endif; ?>
                                
                                <div class="accordion" id="permissionsAccordion">
                                    <!-- System Permissions -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingSystem">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSystem" aria-expanded="true" aria-controls="collapseSystem">
                                                <i class="fas fa-cogs me-2"></i> System Permissions
                                            </button>
                                        </h2>
                                        <div id="collapseSystem" class="accordion-collapse collapse show" aria-labelledby="headingSystem" data-bs-parent="#permissionsAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <?php foreach($permissions as $permission): ?>
                                                        <?php 
                                                        // Only show system permissions in this section
                                                        $system_perms = ['manage_users', 'manage_roles', 'manage_settings', 'view_reports'];
                                                        if (!in_array($permission->permission_name, $system_perms)) continue; 
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <?php $is_checked = in_array($permission->id, $selected_permissions ?? []); ?>
                                                                <input type="checkbox" name="permissions[]" class="form-check-input" id="perm_<?= $permission->id ?>" value="<?= $permission->id ?>" <?= set_checkbox('permissions[]', $permission->id, $is_checked); ?> <?= ($role->role_name === 'Admin') ? 'checked disabled' : ''; ?>>
                                                                <label class="form-check-label" for="perm_<?= $permission->id ?>">
                                                                    <strong><?= ucfirst(str_replace('_', ' ', $permission->permission_name)) ?></strong>
                                                                </label>
                                                                <?php if(!empty($permission->description)): ?>
                                                                    <div class="text-muted small"><?= $permission->description ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Blog Content Permissions -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingBlog">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlog" aria-expanded="true" aria-controls="collapseBlog">
                                                <i class="fas fa-blog me-2"></i> Blog Permissions
                                            </button>
                                        </h2>
                                        <div id="collapseBlog" class="accordion-collapse collapse show" aria-labelledby="headingBlog" data-bs-parent="#permissionsAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <?php foreach($permissions as $permission): ?>
                                                        <?php 
                                                        // Only show blog permissions in this section
                                                        $blog_perms = [
                                                            'create_posts', 'edit_own_posts', 'edit_all_posts', 
                                                            'delete_own_posts', 'delete_all_posts', 'publish_posts', 
                                                            'manage_categories', 'manage_tags', 'moderate_comments',
                                                            'feature_posts'
                                                        ];
                                                        if (!in_array($permission->permission_name, $blog_perms)) continue; 
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <?php $is_checked = in_array($permission->id, $selected_permissions ?? []); ?>
                                                                <input type="checkbox" name="permissions[]" class="form-check-input" id="perm_<?= $permission->id ?>" value="<?= $permission->id ?>" <?= set_checkbox('permissions[]', $permission->id, $is_checked); ?> <?= ($role->role_name === 'Admin') ? 'checked disabled' : ''; ?>>
                                                                <label class="form-check-label" for="perm_<?= $permission->id ?>">
                                                                    <strong><?= ucfirst(str_replace('_', ' ', $permission->permission_name)) ?></strong>
                                                                </label>
                                                                <?php if(!empty($permission->description)): ?>
                                                                    <div class="text-muted small"><?= $permission->description ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Other Permissions -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOther">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOther" aria-expanded="false" aria-controls="collapseOther">
                                                <i class="fas fa-puzzle-piece me-2"></i> Other Permissions
                                            </button>
                                        </h2>
                                        <div id="collapseOther" class="accordion-collapse collapse" aria-labelledby="headingOther" data-bs-parent="#permissionsAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <?php foreach($permissions as $permission): ?>
                                                        <?php 
                                                        // Only show permissions that aren't in the other sections
                                                        $system_perms = ['manage_users', 'manage_roles', 'manage_settings', 'view_reports'];
                                                        $blog_perms = [
                                                            'create_posts', 'edit_own_posts', 'edit_all_posts', 
                                                            'delete_own_posts', 'delete_all_posts', 'publish_posts', 
                                                            'manage_categories', 'manage_tags', 'moderate_comments',
                                                            'feature_posts'
                                                        ];
                                                        $excluded_perms = array_merge($system_perms, $blog_perms);
                                                        if (in_array($permission->permission_name, $excluded_perms)) continue; 
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <?php $is_checked = in_array($permission->id, $selected_permissions ?? []); ?>
                                                                <input type="checkbox" name="permissions[]" class="form-check-input" id="perm_<?= $permission->id ?>" value="<?= $permission->id ?>" <?= set_checkbox('permissions[]', $permission->id, $is_checked); ?> <?= ($role->role_name === 'Admin') ? 'checked disabled' : ''; ?>>
                                                                <label class="form-check-label" for="perm_<?= $permission->id ?>">
                                                                    <strong><?= ucfirst(str_replace('_', ' ', $permission->permission_name)) ?></strong>
                                                                </label>
                                                                <?php if(!empty($permission->description)): ?>
                                                                    <div class="text-muted small"><?= $permission->description ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Role
                            </button>
                            <a href="<?= base_url('Admin/roles'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 