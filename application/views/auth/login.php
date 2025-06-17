<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Secure Access</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom Styles for a More Engaging UI */
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); /* Vibrant gradient background */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden; /* Prevent scrollbar from animation */
            position: relative;
        }

        /* Animated background elements */
        .circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
            opacity: 0.8;
            animation: moveCircles 15s linear infinite;
        }
        .circle:nth-child(1) { width: 100px; height: 100px; top: 10%; left: 5%; animation-delay: 0s; }
        .circle:nth-child(2) { width: 150px; height: 150px; bottom: 15%; right: 10%; animation-delay: 5s; }
        .circle:nth-child(3) { width: 80px; height: 80px; top: 30%; right: 20%; animation-delay: 10s; }
        .circle:nth-child(4) { width: 120px; height: 120px; bottom: 5%; left: 25%; animation-delay: 2s; }
        .circle:nth-child(5) { width: 90px; height: 90px; top: 50%; left: 40%; animation-delay: 7s; }

        @keyframes moveCircles {
            0% { transform: translate(0, 0) scale(1); opacity: 0.8; }
            25% { transform: translate(20px, 30px) scale(1.1); opacity: 0.7; }
            50% { transform: translate(0, 60px) scale(1.2); opacity: 0.9; }
            75% { transform: translate(-20px, 30px) scale(1.1); opacity: 0.7; }
            100% { transform: translate(0, 0) scale(1); opacity: 0.8; }
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex; /* Use flex for internal layout */
            max-width: 900px; /* Constrain max width */
            width: 95%; /* Responsive width */
            z-index: 1; /* Ensure it's above circles */
        }

        .login-image-section {
            background: linear-gradient(to right, #4e73df, #224abe); /* Original gradient */
            color: #fff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-image-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .login-image-section p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        .login-image-section .fas {
            font-size: 4rem; /* Larger icon */
            margin-bottom: 25px;
            color: rgba(255, 255, 255, 0.8); /* Slightly less opaque */
        }

        .login-form-section {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-section .h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .form-control-lg-custom {
            border-radius: 50px; /* More rounded inputs */
            padding: 15px 25px;
            font-size: 0.95rem;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }
        .form-control-lg-custom:focus {
            box-shadow: 0 0 0 0.2rem rgba(82, 137, 255, 0.25);
            border-color: #5289ff;
        }

        .input-group-text {
            background-color: #f8f9fa; /* Light background for icon */
            border-right: none;
            border-radius: 50px 0 0 50px; /* Match input border radius */
            padding: 15px 20px;
            border: 1px solid #ddd;
        }
        .input-group .form-control-lg-custom {
            border-left: none;
            border-radius: 0 50px 50px 0; /* Match input border radius */
        }

        .btn-primary-custom {
            background: linear-gradient(to right, #2575fc, #6a11cb); /* Button gradient */
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            background: linear-gradient(to right, #1a5ac9, #520ea3);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #666;
        }

        .text-center a.small {
            color: #5289ff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .text-center a.small:hover {
            color: #224abe;
        }

        .alert-dismissible .btn-close {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;
            padding: 1.25rem 1rem;
            background-color: transparent;
            border: 0;
            opacity: .5;
        }
        .alert-dismissible .btn-close:hover {
            opacity: .75;
        }
        .alert-dismissible .btn-close:focus {
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25);
        }
        .alert-dismissible .btn-close {
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: .25em .25em;
            font-size: 0.9rem; /* Smaller close button for alerts */
            color: #000;
            background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
            border: 0;
            border-radius: .25rem;
            opacity: .5;
        }


        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .login-container .col-lg-6 {
                width: 100%;
                max-width: 100%; /* Ensure columns take full width on smaller screens */
            }
            .login-image-section {
                border-radius: 15px 15px 0 0; /* Adjust border radius for top on mobile */
                height: auto !important; /* Remove fixed height from inline style */
                padding: 30px;
            }
            .login-form-section {
                padding: 30px;
            }
            .login-container {
                flex-direction: column; /* Stack columns vertically */
            }
        }

        @media (max-width: 575.98px) {
            .login-container {
                margin: 20px;
            }
            .login-image-section h1 {
                font-size: 2rem;
            }
            .login-image-section .fas {
                font-size: 3rem;
            }
            .form-control-lg-custom {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
            .input-group-text {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>

    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="login-container">
        <div class="col-lg-6 d-none d-lg-flex login-image-section">
            <div class="text-center">
                <i class="fas fa-shield-alt mb-4"></i>
                <h1>Welcome Back!</h1>
                <p class="mb-4">Securely access your account to manage users, roles, and system configurations with ease.</p>
                <p class="small">Our robust multi-role management ensures that every user has tailored access, maintaining data integrity and operational efficiency.</p>
            </div>
        </div>
        <div class="col-lg-6 login-form-section">
            <div class="text-center">
                <h4 class="mb-4">Login to Your Account</h4>
            </div>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); ?>
            
            <?php echo form_open('Auth/login', ['class' => 'user']); ?>
                <div class="form-group mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" id="username" class="form-control form-control-lg-custom" placeholder="Enter Username..." value="<?php echo set_value('username'); ?>" required>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control form-control-lg-custom" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary-custom btn-block w-100">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            <?php echo form_close(); ?>
            
            <hr class="my-4">
            <div class="text-center mb-3">
                <a class="small" href="#">Forgot Password?</a>
            </div>
            <div class="text-center">
                <a class="small" href="<?php echo base_url('Auth/register'); ?>">Create an Account!</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>