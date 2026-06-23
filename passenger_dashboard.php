<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'passenger') {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rides</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <header class="site-header">
            <div class="logo-icon">📋</div>
            <h1>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h1>
            <div style="margin-left: auto; display: flex; gap: 15px;">
                <a href="index.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">
                    ➕ New Booking
                </a>
                <a href="logout.php" style="color: #e74c3c; text-decoration: none; font-weight: 600;">
                    🚪 Logout
                </a>
            </div>
        </header>

        <div class="card">
            <h2 class="card-title">My Bookings</h2>

            <?php
            $passenger_id = $_SESSION['user_id'];
            
            $sql = "SELECT 
                Ride.Ride_ID,
                Driver.Driver_Name,
                Ride.Pickup_Location,
                Ride.Destination,
                Ride.Ride_Date,
                Ride.Pickup_Time,
                Ride.Fare,
                Ride.Ride_Status
            FROM Ride
            LEFT JOIN Driver ON Ride.Driver_ID = Driver.Driver_ID
            WHERE Ride.Passenger_ID = $passenger_id
            ORDER BY Ride.Ride_ID DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                    <tr>
                        <th>#</th>
                        <th>Driver</th>
                        <th>Pickup</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Fare</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>";

                while($row = $result->fetch_assoc()) {
                    $cancel_button = '';
                    if ($row['Ride_Status'] == 'Booked') {
                        $cancel_button = "<a href='cancel_ride.php?id=" . $row['Ride_ID'] . "' 
                                         onclick='return confirm(\"Cancel this ride?\")' 
                                         style='color: #e74c3c; text-decoration: none; font-weight: 600;'>
                                         ❌ Cancel</a>";
                    } else {
                        $cancel_button = "<span style='color: #95a5a6;'>—</span>";
                    }

                    $status_color = $row['Ride_Status'] == 'Booked' ? '#2ecc71' : 
                                   ($row['Ride_Status'] == 'Accepted' ? '#f39c12' : '#e74c3c');

                    echo "<tr>
                        <td>" . $row["Ride_ID"] . "</td>
                        <td>" . ($row["Driver_Name"] ?? 'Not Assigned') . "</td>
                        <td>" . $row["Pickup_Location"] . "</td>
                        <td>" . $row["Destination"] . "</td>
                        <td>" . $row["Ride_Date"] . "</td>
                        <td>" . $row["Pickup_Time"] . "</td>
                        <td>Rs. " . $row["Fare"] . "</td>
                        <td style='color: $status_color; font-weight: 600;'>" . $row["Ride_Status"] . "</td>
                        <td>" . $cancel_button . "</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center; color: #6c757d; padding: 20px;'>No rides booked yet.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>