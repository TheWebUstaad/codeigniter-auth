<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="container-fluid py-5 dashboard-container">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <h1 class="display-6 fw-bold text-dark-blue">
            <i class="fas fa-grip-vertical me-3 text-primary"></i>Dashboard Overview
        </h1>
        <button class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-chart-line me-2"></i> View Analytics
        </button>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="card welcome-card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body p-5 d-flex align-items-center">
                    <div class="flex-shrink-0 me-5">
                        <div class="welcome-avatar bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg">
                            <i class="fas fa-user fa-1x"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="display-5 fw-bold text-dark-blue mb-3">Hello, <span class="text-primary"><?php echo $user_info['username']; ?></span>!</h2>
                        <p class="lead mb-3 text-secondary">
                            You're currently logged in as a 
                            <?php
                            $badge_class = 'bg-primary';
                            $role_icon = 'fas fa-user';
                            
                            if (isset($user_info['role_name'])) {
                                if ($user_info['role_name'] === 'Admin') {
                                    $badge_class = 'bg-danger';
                                    $role_icon = 'fas fa-shield-alt';
                                } elseif ($user_info['role_name'] === 'Editor') {
                                    $badge_class = 'bg-success';
                                    $role_icon = 'fas fa-feather-alt';
                                } elseif ($user_info['role_name'] === 'User') {
                                    $badge_class = 'bg-info';
                                    $role_icon = 'fas fa-user-circle';
                                }
                            ?>
                                <span class="badge role-badge rounded-pill <?php echo $badge_class; ?> px-3 py-2 fw-normal fs-6 shadow-sm">
                                    <i class="<?php echo $role_icon; ?> me-2"></i><?php echo $user_info['role_name']; ?>
                                </span>
                            <?php } ?>
                        </p>
                        <p class="text-muted fs-6 mb-0">Explore your personalized dashboard. Your access and features are tailored to your assigned role, ensuring a secure and efficient experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5 border-light-grey">

    <div class="row g-4 mb-5">
    <?php if ($user_info['role_name'] === 'Admin'): ?>
        <div class="col-xl-4 col-md-6">
            <div class="card feature-card border-0 rounded-4 shadow-sm h-100 animate-card-fade-in hover-raise">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-light-primary text-primary rounded-circle me-4 shadow-sm">
                            <i class="fas fa-users-cog fa-lg"></i>
                        </div>
                        <h5 class="card-title fw-semibold text-primary mb-0">User Management</h5>
                    </div>
                    <p class="card-text text-secondary mb-4">Take full control of user accounts, manage their roles, and oversee system access with powerful tools.</p>
                    <a href="<?php echo base_url('Admin/users'); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 animate-arrow-button">
                        Manage Users <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card feature-card border-0 rounded-4 shadow-sm h-100 animate-card-fade-in hover-raise">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-light-success text-success rounded-circle me-4 shadow-sm">
                            <i class="fas fa-id-badge fa-lg"></i>
                        </div>
                        <h5 class="card-title fw-semibold text-success mb-0">Role & Permission Control</h5>
                    </div>
                    <p class="card-text text-secondary mb-4">Define granular permissions and assign roles to users, ensuring secure and tailored access to features.</p>
                    <a href="<?php echo base_url('Admin/roles'); ?>" class="btn btn-outline-success btn-sm rounded-pill px-4 animate-arrow-button">
                        Configure Roles <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card feature-card border-0 rounded-4 shadow-sm h-100 animate-card-fade-in hover-raise">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-light-info text-info rounded-circle me-4 shadow-sm">
                            <i class="fas fa-sliders-h fa-lg"></i>
                        </div>
                        <h5 class="card-title fw-semibold text-info mb-0">System Configurations</h5>
                    </div>
                    <p class="card-text text-secondary mb-4">Adjust core application settings, integrate services, and fine-tune system behavior for optimal performance.</p>
                    <a href="#" class="btn btn-outline-info btn-sm rounded-pill px-4 animate-arrow-button">
                        Edit Settings <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    <?php elseif ($user_info['role_name'] === 'Editor'): ?>
        <div class="col-xl-4 col-md-6">
            <div class="card feature-card border-0 rounded-4 shadow-sm h-100 animate-card-fade-in hover-raise">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-light-primary text-primary rounded-circle me-4 shadow-sm">
                            <i class="fas fa-feather fa-lg"></i>
                        </div>
                        <h5 class="card-title fw-semibold text-primary mb-0">Content Creation</h5>
                    </div>
                    <p class="card-text text-secondary mb-4">Craft new articles, edit existing content, and publish updates with a rich and intuitive editor.</p>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-pill px-4 animate-arrow-button">
                        Start New Post <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card feature-card border-0 rounded-4 shadow-sm h-100 animate-card-fade-in hover-raise">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-light-success text-success rounded-circle me-4 shadow-sm">
                            <i class="fas fa-photo-video fa-lg"></i>
                        </div>
                        <h5 class="card-title fw-semibold text-success mb-0">Media Asset Library</h5>
                    </div>
                    <p class="card-text text-secondary mb-4">Upload, manage, and categorize all your digital assets, including images, videos, and documents.</p>
                    <a href="#" class="btn btn-outline-success btn-sm rounded-pill px-4 animate-arrow-button">
                        Browse Media <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    <?php elseif ($user_info['role_name'] === 'User'): ?>
        <div class="col-xl-4 col-md-6">
            <div class="card feature-card border-0 rounded-4 shadow-sm h-100 animate-card-fade-in hover-raise">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-light-info text-info rounded-circle me-4 shadow-sm">
                            <i class="fas fa-book-open fa-lg"></i>
                        </div>
                        <h5 class="card-title fw-semibold text-info mb-0">Read & Explore Content</h5>
                    </div>
                    <p class="card-text text-secondary mb-4">Dive into a vast collection of articles, news, and resources tailored to your interests.</p>
                    <a href="#" class="btn btn-outline-info btn-sm rounded-pill px-4 animate-arrow-button">
                        Discover Articles <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card feature-card border-0 rounded-4 shadow-sm h-100 animate-card-fade-in hover-raise">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-light-primary text-primary rounded-circle me-4 shadow-sm">
                            <i class="fas fa-id-card-alt fa-lg"></i>
                        </div>
                        <h5 class="card-title fw-semibold text-primary mb-0">Personal Profile Settings</h5>
                    </div>
                    <p class="card-text text-secondary mb-4">Manage your personal details, update your preferences, and secure your account credentials.</p>
                    <a href="<?php echo base_url('User/update_profile'); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 animate-arrow-button">
                        Edit My Profile <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <?php if (isset($user_info['permissions']) && is_array($user_info['permissions']) && !empty($user_info['permissions'])): ?>
    <hr class="my-5 border-light-grey">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm animate-fade-in-up">
                <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex align-items-center">
                    <h5 class="card-title fw-semibold text-dark-blue mb-0">
                        <i class="fas fa-lock me-3 text-warning"></i>Your Current Permissions
                    </h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row g-3">
                        <?php foreach ($user_info['permissions'] as $permission): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="d-flex align-items-center text-secondary animate-permission-item">
                                    <i class="fas fa-check-circle text-success me-3 fs-5"></i>
                                    <span class="fw-medium"><?php echo ucfirst(str_replace('_', ' ', $permission)); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Real Data Analytics Section -->
    <?php if ($user_info['role_name'] === 'Admin'): ?>
    <hr class="my-5 border-light-grey">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="fw-bold text-dark-blue">
                    <i class="fas fa-chart-pie me-3 text-primary animate-pop-in"></i>System Analytics
                </h3>
            </div>
        </div>
    </div>

    <!-- Actual Data Tables Row -->
    <div class="row g-4 mb-5">
        <!-- Users List -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 animate-fade-in-up">
                <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold text-dark-blue mb-0">
                        <i class="fas fa-users me-2 text-primary"></i> Users
                    </h5>
                    <a href="<?php echo base_url('Admin/users'); ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="fas fa-eye me-2"></i>View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="ps-4">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col" class="text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($recent_users) && !empty($recent_users)): ?>
                                    <?php foreach($recent_users as $user): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <span class="ms-2"><?= $user->username ?></span>
                                            </div>
                                        </td>
                                        <td><?= $user->email ?></td>
                                        <td>
                                            <span class="badge bg-<?= $user->role_name === 'Admin' ? 'danger' : ($user->role_name === 'Editor' ? 'success' : 'info') ?> rounded-pill">
                                                <?= $user->role_name ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="badge bg-<?= $user->active ? 'success' : 'warning' ?> rounded-pill">
                                                <?= $user->active ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No users found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Roles List -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 animate-fade-in-up">
                <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold text-dark-blue mb-0">
                        <i class="fas fa-user-tag me-2 text-success"></i> Roles
                    </h5>
                    <a href="<?php echo base_url('Admin/roles'); ?>" class="btn btn-sm btn-outline-success rounded-pill">
                        <i class="fas fa-eye me-2"></i>View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="ps-4">Role Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" class="text-end pe-4">Users</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($roles) && !empty($roles)): ?>
                                    <?php foreach($roles as $role): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <span class="ms-2"><?= $role->role_name ?></span>
                                            </div>
                                        </td>
                                        <td><?= $role->description ? $role->description : 'No description' ?></td>
                                        <td class="text-end pe-4">
                                            <span class="badge bg-primary rounded-pill">
                                                <?= $role->user_count ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">No roles found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <!-- Posts List -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold text-dark-blue mb-0">
                        <i class="fas fa-file-alt me-2 text-info"></i> Recent Posts
                    </h5>
                    <?php if (in_array($user_info['role_name'], ['Admin', 'Editor'])): ?>
                    <a href="<?php echo base_url('Admin_Blog/posts'); ?>" class="btn btn-sm btn-outline-info rounded-pill">
                        <i class="fas fa-eye me-2"></i>View All
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="ps-4">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Author</th>
                                    <th scope="col" class="text-end pe-4">Published</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($recent_posts) && !empty($recent_posts)): ?>
                                    <?php foreach($recent_posts as $post): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-alt text-info me-2"></i>
                                                <span class="fw-medium"><?php echo $post->title; ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-info text-info rounded-pill">
                                                <?php echo $post->category_name; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $post->author_name; ?></td>
                                        <td class="text-end pe-4">
                                            <?php echo date('M d, Y', strtotime($post->created_at)); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center p-4 text-muted">No posts found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Categories List -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 animate-fade-in-up" style="animation-delay: 0.6s">
                <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold text-dark-blue mb-0">
                        <i class="fas fa-folder me-2 text-warning"></i> Categories
                    </h5>
                    <?php if (in_array($user_info['role_name'], ['Admin', 'Editor'])): ?>
                    <a href="<?php echo base_url('Admin_Blog/categories'); ?>" class="btn btn-sm btn-outline-warning rounded-pill">
                        <i class="fas fa-eye me-2"></i>View All
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="ps-4">Category Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" class="text-end pe-4">Posts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($categories) && !empty($categories)): ?>
                                    <?php foreach($categories as $category): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-folder text-warning me-2"></i>
                                                <span class="fw-medium"><?php echo $category->name; ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo isset($category->description) ? substr($category->description, 0, 50) . (strlen($category->description) > 50 ? '...' : '') : 'No description'; ?></td>
                                        <td class="text-end pe-4">
                                            <span class="badge bg-light text-dark rounded-pill">
                                                <?php echo $category->post_count; ?> posts
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center p-4 text-muted">No categories found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
/* --- General Body & Typography --- */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8faff; /* Light, airy background */
    color: #495057; /* Standard text color */
}

.dashboard-container {
    padding-top: 3rem !important;
    padding-bottom: 3rem !important;
}

.text-dark-blue {
    color: #2c3e50;
}
.text-primary { color: #5B67C5 !important; } /* A slightly softer, modern primary blue */
.text-success { color: #34A853 !important; } /* A fresh green */
.text-info { color: #4285F4 !important; }    /* A vibrant blue */
.text-danger { color: #EA4335 !important; }  /* A punchy red */
.text-secondary { color: #6c757d !important; } /* Standard secondary */
.text-warning { color: #FBBC04 !important; }  /* A golden yellow */

.bg-gradient-primary {
    background: linear-gradient(45deg, var(--primary-color), #4e73df);
}

/* --- Cards General --- */
.card {
    border-radius: 1.25rem !important; /* More pronounced rounded corners */
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.05) !important; /* Softer, larger shadow */
    transition: all 0.3s ease-in-out;
    border: none; /* Remove default Bootstrap border */
}

/* Welcome Card Specifics */
.welcome-card {
    background: #ffffff;
    transition: all 0.3s ease;
}

.welcome-avatar {
    width: 80px;
    height: 80px;
    font-size: 2rem;
}

.role-badge {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    opacity: 1 !important;
    position: relative;
    z-index: 1;
}

.role-badge i {
    display: inline-block;
    margin-right: 0.5rem;
}

/* Feature Cards Specifics */
.feature-card {
    background-color: #ffffff;
}

.feature-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    border-radius: 50% !important;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.08); /* Icon specific shadow */
}

/* Light background colors for icons */
.bg-light-primary { background-color: #e6e9f5 !important; }
.bg-light-success { background-color: #e9f6ed !important; }
.bg-light-info { background-color: #e0ecfb !important; }
.bg-light-warning { background-color: #fdf5e0 !important; }


/* --- Buttons --- */
.btn {
    border-radius: 50px !important; /* Pill buttons */
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #5B67C5;
    border-color: #5B67C5;
}
.btn-primary:hover {
    background-color: #4a54b4;
    border-color: #4a54b4;
    transform: translateY(-2px);
}
.btn-outline-primary { border-color: #5B67C5; color: #5B67C5; }
.btn-outline-primary:hover { background-color: #5B67C5; color: white; }

.btn-success { background-color: #34A853; border-color: #34A853; }
.btn-success:hover { background-color: #2c9448; border-color: #2c9448; }
.btn-outline-success { border-color: #34A853; color: #34A853; }
.btn-outline-success:hover { background-color: #34A853; color: white; }

.btn-info { background-color: #4285F4; border-color: #4285F4; }
.btn-info:hover { background-color: #3676d3; border-color: #3676d3; }
.btn-outline-info { border-color: #4285F4; color: #4285F4; }
.btn-outline-info:hover { background-color: #4285F4; color: white; }


/* --- Badges --- */
.badge {
    padding: 0.5rem 1rem !important; /* Larger badges */
    font-size: 0.95em !important;
    font-weight: 600 !important;
}
.badge i {
    font-size: 0.8em; /* Slightly smaller icon within badge */
}

/* --- Separator --- */
.border-light-grey {
    border-color: #dee2e6 !important; /* Lighter border for hr */
    opacity: 0.5; /* More subtle line */
}

/* --- Animations --- */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInRight {
    from { transform: translateX(-20px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes popIn {
    0% { transform: scale(0.5); opacity: 0; }
    80% { transform: scale(1.05); opacity: 1; }
    100% { transform: scale(1); }
}

@keyframes fadeInCard {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Apply animations */
.icon-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}

.animate-pop-in {
    animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
}
.animate-slide-right {
    animation: slideInRight 0.7s ease-out forwards;
}
.animate-fade-in {
    animation: fadeIn 0.8s ease-out 0.2s forwards; /* Slight delay */
    opacity: 0; /* Hidden initially */
}
.animate-fade-in-late {
    animation: fadeIn 0.8s ease-out 0.4s forwards; /* More delay */
    opacity: 0; /* Hidden initially */
}
.animate-pop-in-late {
    animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.5s forwards;
    opacity: 0; /* Hidden initially */
}

.animate-card-fade-in {
    animation: fadeInCard 0.6s ease-out forwards;
    opacity: 0; /* Hidden initially */
}
/* Stagger animations for cards */
.col-xl-4:nth-child(1) .animate-card-fade-in { animation-delay: 0.3s; }
.col-xl-4:nth-child(2) .animate-card-fade-in { animation-delay: 0.4s; }
.col-xl-4:nth-child(3) .animate-card-fade-in { animation-delay: 0.5s; }
.col-xl-4:nth-child(4) .animate-card-fade-in { animation-delay: 0.6s; }


.animate-fade-in-up {
    animation: fadeInUp 0.7s ease-out 0.6s forwards;
    opacity: 0;
}

/* Button Animations */
.animate-button {
    transition: all 0.3s ease;
}
.animate-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}

.animate-arrow-button i {
    transition: transform 0.2s ease-in-out;
}
.animate-arrow-button:hover i {
    transform: translateX(5px);
}

/* Hover effect for cards */
.hover-raise:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
}

/* Permission items animation */
.animate-permission-item {
    animation: fadeIn 0.5s ease-out forwards;
    opacity: 0;
    /* Stagger permission items if many */
}
.col-md-4:nth-child(odd) .animate-permission-item { animation-delay: 0.7s; }
.col-md-4:nth-child(even) .animate-permission-item { animation-delay: 0.8s; }

/* New Analytics Styles */
.bg-success-soft { background-color: rgba(52, 168, 83, 0.15); }
.bg-danger-soft { background-color: rgba(234, 67, 53, 0.15); }
.bg-warning-soft { background-color: rgba(251, 188, 4, 0.15); }
.bg-light-warning { background-color: #fdf5e0 !important; }
.text-warning { color: #FBBC04 !important; }

/* Metric Cards */
.metric-card {
    overflow: hidden; /* For animations */
}
.metric-card .metric-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}
.metric-card:hover .metric-icon {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

/* Activity Timeline */
.activity-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

/* Traffic Source Dots */
.traffic-source-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

/* Device Icons */
.device-item i {
    width: 20px;
    text-align: center;
}

/* Animation delays for staggered effect */
.animate-fade-in-up {
    animation-fill-mode: both;
}
</style>