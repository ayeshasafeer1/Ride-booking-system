<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RideSwift</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh;">

    <div style="max-width: 400px; margin: auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 40px;">🚖</div>
            <h2>RideSwift</h2>
        </div>

        <?php if (isset($_GET['registered'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; text-align: center; font-weight: 600;">
                ✅ Registration successful! Please login.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px; text-align: center; font-weight: 600;">
                ❌ Invalid email or password
            </div>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">User Type</label>
                <select name="user_type" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;">
                    <option value="passenger">👤 Passenger</option>
                    <option value="driver">🚗 Driver</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Email</label>
                <input type="email" name="email" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Password</label>
                <input type="password" name="password" style="width:100%; padding:10px; border-radius:6px; border:2px solid #ddd;" required>
            </div>

            <button type="submit" style="width:100%; padding:12px; background:#4361ee; color:white; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                Login
            </button>
        </form>

        <div style="text-align: center; margin-top: 15px;">
            <a href="register.php" style="color: #4361ee; text-decoration: none;">
                Don't have an account? Register here
            </a>
        </div>
    </div>

</body>
</html>