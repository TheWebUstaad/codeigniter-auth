<?php include(APPPATH . 'views/templates/header.php'); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                <?php echo form_open('Auth/login'); ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo set_value('username'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                <?php echo form_close(); ?>
                <p class="mt-3">Don't have an account? <a href="<?php echo base_url('Auth/register'); ?>">Register here</a></p>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'views/templates/footer.php'); ?>