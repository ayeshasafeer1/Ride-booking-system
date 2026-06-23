<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rides</title>
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
            <div class="logo-icon">📋</div>
            <h1>My Rides</h1>
            <div style="margin-left: auto;">
                <a href="index.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">
                    ➕ New Booking
                </a>
            </div>
        </header>

        <!-- Success message after booking -->
        <?php if (isset($_GET['success'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
                ✅ Ride booked successfully!
            </div>
        <?php endif; ?>

        <div class="card">
            <h2 class="card-title">All Bookings</h2>

            <?php
            include 'db_connect.php';

            $sql = "SELECT 
                Ride.Ride_ID,
                Passenger.Passenger_Name,
                Driver.Driver_Name,
                Ride.Pickup_Location,
                Ride.Destination,
                Ride.Ride_Date,
                Ride.Pickup_Time,
                Ride.Fare,
                Ride.Ride_Status
            FROM Ride
            INNER JOIN Passenger ON Ride.Passenger_ID = Passenger.Passenger_ID
            INNER JOIN Driver ON Ride.Driver_ID = Driver.Driver_ID
            ORDER BY Ride.Ride_ID DESC";

            $result = $conn->query($sql);

            if (!$result) {
                die("Query failed: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Passenger</th>
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
                    // Status color coding
                    $status_color = '#2ecc71'; // green for booked
                    if ($row['Ride_Status'] == 'Cancelled') {
                        $status_color = '#e74c3c'; // red for cancelled
                    }

                    // Cancel button only if not cancelled
                    $cancel_button = '';
                    if ($row['Ride_Status'] != 'Cancelled') {
                        $cancel_button = "<a href='cancel_ride.php?id=" . $row['Ride_ID'] . "' 
                                        onclick='return confirm(\"Are you sure you want to cancel this ride?\")'
                                         style='color: #e74c3c; text-decoration: none; font-weight: 600;'>
                                         ❌ Cancel</a>";
                    } else {
                        $cancel_button = "<span style='color: #95a5a6;'>—</span>";
                    }

                    echo "<tr>
                        <td>" . $row["Ride_ID"] . "</td>
                        <td>" . $row["Passenger_Name"] . "</td>
                        <td>" . $row["Driver_Name"] . "</td>
                        <td>" . $row["Pickup_Location"] . "</td>
                        <td>" . $row["Destination"] . "</td>
                        <td>" . $row["Ride_Date"] . "</td>
                        <td>" . $row["Pickup_Time"] . "</td>
                        <td>Rs. " . $row["Fare"] . "</td>
                        <td style='color: " . $status_color . "; font-weight: 600;'>" . $row["Ride_Status"] . "</td>
                        <td>" . $cancel_button . "</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center; color: #6c757d; padding: 20px;'>No rides booked yet.</p>";
            }

            $conn->close();
            ?>
        </div>

    </div>
</body>
</html>