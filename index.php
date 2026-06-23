<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'passenger') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Booking System</title>
    <link rel="stylesheet" href="style.css">
    <div style="margin-left: auto; display: flex; gap: 15px;">
    <a href="my_rides.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">
        📋 My Rides
    </a>
    <a href="driver_dashboard.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">
        🚗 Driver
    </a>
</div>
</head>

<body>
    <div class="wrapper">

        <header class="site-header">
            <div class="logo-icon">🚖</div>
            <h1>RideSwift</h1>
            <div style="margin-left: auto;">
                <a href="my_rides.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">
                    📋 My Rides
                </a>
            </div>
        </header>

        <div class="card">
            <h2 class="card-title">Book a Ride</h2>

            <form action="book_ride.php" method="POST">
                <div class="form-group">
                    <label>Passenger Name</label>
                    <input type="text" name="passenger_name" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" required>
                </div>

                <div class="form-group">
                    <label>Pickup Location</label>
                    <input type="text" name="pickup" required>
                </div>

                <div class="form-group">
                    <label>Destination</label>
                    <input type="text" name="destination" required>
                </div>

                <div class="form-group">
                    <label>Ride Date</label>
                    <input type="date" name="ride_date" required>
                </div>

                <div class="form-group">
                    <label>Pickup Time</label>
                    <input type="time" name="pickup_time" required>
                </div>

                <div class="form-group">
                    <label>Fare (Rs.)</label>
                    <input type="number" step="0.01" name="fare" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    🚗 Book Ride
                </button>
            </form>
        </div>

    </div>
</body>
</html>