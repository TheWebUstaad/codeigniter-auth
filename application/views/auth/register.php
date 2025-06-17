<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Create Your Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --accent-color: #1cc88a; /* A vibrant green for success/highlight */
            --text-color: #333;
            --light-text-color: #666;
            --card-bg: rgba(255, 255, 255, 0.98);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px; /* Added padding to prevent sticking */
            overflow-x: hidden; /* Prevent horizontal scroll */
            position: relative;
        }

        /* Background animation elements */
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        .animated-bg span {
            position: absolute;
            display: block;
            list-style: none;
            background: rgba(255, 255, 255, 0.15);
            animation: animate 25s linear infinite;
            bottom: -150px;
            border-radius: 50%;
        }
        .animated-bg span:nth-child(1) { left: 25%; width: 80px; height: 80px; animation-delay: 0s; }
        .animated-bg span:nth-child(2) { left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s; }
        .animated-bg span:nth-child(3) { left: 70%; width: 20px; height: 20px; animation-delay: 4s; }
        .animated-bg span:nth-child(4) { left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s; }
        .animated-bg span:nth-child(5) { left: 65%; width: 20px; height: 20px; animation-delay: 0s; }
        .animated-bg span:nth-child(6) { left: 75%; width: 110px; height: 110px; animation-delay: 3s; }
        .animated-bg span:nth-child(7) { left: 35%; width: 150px; height: 150px; animation-delay: 7s; }
        .animated-bg span:nth-child(8) { left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; }
        .animated-bg span:nth-child(9) { left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; }
        .animated-bg span:nth-child(10) { left: 85%; width: 150px; height: 150px; animation-delay: 0s; animation-duration: 11s; }

        @keyframes animate {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; border-radius: 0; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; border-radius: 50%; }
        }

        .register-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 500px; /* Max width for the form */
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 1; /* Ensure card is above background animations */
            animation: fadeInScale 0.6s ease-out forwards;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .register-card h1 {
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 2.2rem;
        }

        .register-card .lead {
            color: var(--light-text-color);
            margin-bottom: 30px;
            font-size: 1.05rem;
        }

        /* Form Floating Labels & Inputs */
        .form-floating-custom {
            position: relative;
            margin-bottom: 25px; /* Increased margin for better spacing */
        }
        .form-floating-custom input {
            border: 1px solid #ddd;
            border-radius: 10px; /* Slightly rounded corners for inputs */
            padding: 15px 20px 15px 45px; /* Adjust padding for icon and label */
            width: 100%;
            height: auto !important; /* Override default Bootstrap height */
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        .form-floating-custom input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 117, 252, 0.25);
            background-color: #fff;
        }
        .form-floating-custom label {
            position: absolute;
            top: 50%;
            left: 45px; /* Align with input text, next to icon */
            transform: translateY(-50%);
            color: var(--light-text-color);
            pointer-events: none;
            transition: all 0.2s ease-out;
            font-size: 1rem;
        }
        .form-floating-custom input:focus ~ label,
        .form-floating-custom input:not(:placeholder-shown) ~ label {
            top: 0;
            left: 15px; /* Move to top-left corner */
            transform: translateY(-50%) scale(0.8);
            background-color: var(--card-bg); /* Match card background to hide input border on top */
            padding: 0 5px;
            color: var(--primary-color);
            font-weight: 500;
            font-size: 0.9rem;
        }
        .form-floating-custom .form-control-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text-color);
            font-size: 1.1rem;
            z-index: 2; /* Ensure icon is above label */
        }

        /* Password Strength Indicator */
        #passwordStrength {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 8px; /* Space from input */
            margin-bottom: 20px; /* Space before next element */
            display: flex;
        }
        .strength-bar {
            height: 100%;
            width: 0%; /* Start at 0 */
            transition: width 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }
        .strength-bar.weak { background-color: #e74a3b; width: 25%; }
        .strength-bar.medium { background-color: #f6c23e; width: 50%; }
        .strength-bar.strong { background-color: #1cc88a; width: 75%; }
        .strength-bar.very-strong { background-color: #36b9cc; width: 100%; }


        .btn-register-custom {
            background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
            border: none;
            border-radius: 50px; /* Pill shape */
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .btn-register-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
            opacity: 0.95;
            color: #fff; /* Keep text white on hover */
        }
        .btn-register-custom:active {
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        hr {
            margin: 30px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .links-section a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }
        .links-section a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Alerts */
        .alert {
            font-size: 0.95rem;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 25px;
            text-align: left; /* Align alert text left */
        }
        .alert-danger {
            background-color: #ffe0e6;
            color: #d92b4a;
            border-color: #d92b4a;
        }
        .alert-success {
            background-color: #e6ffed;
            color: #27ae60;
            border-color: #27ae60;
        }
        .alert .fas {
            margin-right: 8px;
        }
        .alert-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.75rem 1.25rem;
            color: inherit;
            opacity: .8;
        }
    </style>
</head>
<body>

    <div class="animated-bg">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="register-card">
        <h1 class="mb-3"><i class="fas fa-user-plus mr-2"></i> Create Your Account</h1>
        <p class="lead">Join our community and unlock exclusive features.</p>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i>', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); ?>
        
        <?php echo form_open('Auth/register'); ?>
            <div class="form-group form-floating-custom">
                <i class="fas fa-user form-control-icon"></i>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo set_value('username'); ?>" required>
                <label for="username">Username</label>
            </div>
            
            <div class="form-group form-floating-custom">
                <i class="fas fa-envelope form-control-icon"></i>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="<?php echo set_value('email'); ?>" required>
                <label for="email">Email Address</label>
            </div>
            
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group form-floating-custom">
                        <i class="fas fa-lock form-control-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group form-floating-custom">
                        <i class="fas fa-key form-control-icon"></i>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                        <label for="confirm_password">Confirm Password</label>
                    </div>
                </div>
            </div>
            <div id="passwordStrength"></div> <button type="submit" class="btn btn-register-custom mt-4">
                <i class="fas fa-user-plus mr-2"></i> Register Account
            </button>
        <?php echo form_close(); ?>
        
        <hr>
        <div class="links-section">
            <p class="mb-2"><a href="#">Forgot Password?</a></p>
            <p><a href="<?php echo base_url('Auth/login'); ?>">Already have an account? Login!</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirm_password');
            const strengthIndicator = document.getElementById('passwordStrength');
            
            function updatePasswordStrength() {
                const password = passwordInput.value;
                let strength = 0;
                
                // Criteria for strength
                const hasLowercase = /[a-z]/.test(password);
                const hasUppercase = /[A-Z]/.test(password);
                const hasDigit = /\d/.test(password);
                const hasSpecialChar = /[^a-zA-Z\d\s]/.test(password);

                if (password.length >= 8) strength++;
                if (hasLowercase && hasUppercase) strength++;
                if (hasDigit) strength++;
                if (hasSpecialChar) strength++;

                strengthIndicator.innerHTML = ''; // Clear previous bars

                const strengthLevelMap = {
                    0: 'empty',
                    1: 'weak',
                    2: 'medium',
                    3: 'strong',
                    4: 'very-strong'
                };
                const currentStrengthClass = strengthLevelMap[strength] || 'empty';

                for (let i = 0; i < 4; i++) {
                    const span = document.createElement('span');
                    span.classList.add('strength-bar');
                    if (password.length > 0) { // Only show colored bars if password is not empty
                        if (strength >= (i + 1)) {
                            span.classList.add(currentStrengthClass); // Apply the class for coloring and width
                        }
                    }
                    strengthIndicator.appendChild(span);
                }
            }

            function updateConfirmPassword() {
                if (confirmInput.value.length === 0) {
                    confirmInput.style.borderColor = '#ddd'; // Default border for empty
                } else if (confirmInput.value === passwordInput.value) {
                    confirmInput.style.borderColor = '#1cc88a'; // Green
                } else {
                    confirmInput.style.borderColor = '#e74a3b'; // Red
                }
            }
            
            passwordInput.addEventListener('input', updatePasswordStrength);
            passwordInput.addEventListener('input', updateConfirmPassword);
            confirmInput.addEventListener('input', updateConfirmPassword);

            // Initial call to set state on page load
            updatePasswordStrength();
            updateConfirmPassword();
        });
    </script>
</body>
</html>