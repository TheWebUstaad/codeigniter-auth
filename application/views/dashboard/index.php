<?php include(APPPATH . 'views/templates/header.php'); ?>

<div class="jumbotron">
    <h1 class="display-4">Welcome to Your Dashboard, <?php echo $user_info['username']; ?>!</h1>
    <p class="lead">You are logged in as a <strong><?php echo $user_info['role_name']; ?></strong>.</p>
    <hr class="my-4">
    <p>This is your personalized dashboard. Your access and available features depend on your assigned role.</p>

    <?php if ($user_info['role_name'] === 'Admin'): ?>
        <p>As an **Admin**, you have full control over the system, including user and role management.</p>
        <a class="btn btn-primary btn-lg" href="<?php echo base_url('Admin/users'); ?>" role="button">Manage Users</a>
        <a class="btn btn-secondary btn-lg" href="<?php echo base_url('Admin/roles'); ?>" role="button">Manage Roles</a>
    <?php elseif ($user_info['role_name'] === 'Editor'): ?>
        <p>As an **Editor**, you can manage content such as articles, posts, etc.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Manage Posts</a>
    <?php elseif ($user_info['role_name'] === 'User'): ?>
        <p>As a **User**, you have basic access and can view content.</p>
        <a class="btn btn-info btn-lg" href="#" role="button">View Articles</a>
    <?php endif; ?>

    <?php if (isset($user_info['permissions']) && is_array($user_info['permissions'])): ?>
        <h5 class="mt-4">Your Permissions:</h5>
        <ul>
            <?php foreach ($user_info['permissions'] as $permission): ?>
                <li><?php echo $permission; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php include(APPPATH . 'views/templates/footer.php'); ?>