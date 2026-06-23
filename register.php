<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - RideSwift</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-container .form-group {
            margin-bottom: 15px;
        }
        .register-container .btn {
            width: 100%;
            padding: 12px;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body style="background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh;">

    <div class="register-container">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 40px;"></div>
            <h2>Create Account!</h2>
            <p style="color: #6c757d; font-size: 0.9rem;">Join RideSwift today</p>
        </div>

        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" placeholder="03XX-XXXXXXX" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a password" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;" required>
            </div>

            <div class="form-group">
                <label>I am a:</label>
                <select name="user_type" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;">
                    <option value="passenger">👤 Passenger</option>
                    <option value="driver">🚗 Driver</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <div class="login-link">
            <a href="login.php" style="color: #4361ee; text-decoration: none;">
                Already have an account? Login here
            </a>
        </div>
    </div>

</body>
</html>