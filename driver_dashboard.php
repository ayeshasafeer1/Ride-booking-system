<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'driver') {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
?>
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
    <title>Driver Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">

        <header class="site-header">
            <div class="logo-icon">🚗</div>
            <h1>Driver Dashboard</h1>
            <div style="margin-left: auto;">
                <a href="index.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">
                    🏠 Home
                </a>
            </div>
        </header>

        <!-- Success Messages -->
        <?php if (isset($_GET['accepted'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
                ✅ Ride accepted successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['completed'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
                ✅ Ride completed successfully!
            </div>
        <?php endif; ?>

        <div class="card">
            <h2 class="card-title">Available Rides</h2>
            <p style="color: #6c757d; margin-bottom: 15px; font-size: 0.9rem;">
                Click "Accept" to take a ride
            </p>

            <?php
            // Show only rides that are 'Booked' (not yet accepted or cancelled)
            $sql = "SELECT 
                Ride.Ride_ID,
                Passenger.Passenger_Name,
                Ride.Pickup_Location,
                Ride.Destination,
                Ride.Ride_Date,
                Ride.Pickup_Time,
                Ride.Fare,
                Ride.Ride_Status
            FROM Ride
            INNER JOIN Passenger ON Ride.Passenger_ID = Passenger.Passenger_ID
            WHERE Ride.Ride_Status = 'Booked'
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
                        <th>Pickup</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Fare</th>
                        <th>Action</th>
                    </tr>";

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["Ride_ID"] . "</td>
                        <td>" . $row["Passenger_Name"] . "</td>
                        <td>" . $row["Pickup_Location"] . "</td>
                        <td>" . $row["Destination"] . "</td>
                        <td>" . $row["Ride_Date"] . "</td>
                        <td>" . $row["Pickup_Time"] . "</td>
                        <td>Rs. " . $row["Fare"] . "</td>
                        <td>
                            <a href='accept_ride.php?id=" . $row['Ride_ID'] . "' 
                               onclick='return confirm(\"Accept this ride?\")' 
                               style='color: #2ecc71; text-decoration: none; font-weight: 600;'>
                               ✅ Accept
                            </a>
                        </td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center; color: #6c757d; padding: 20px;'>
                        No available rides right now.
                      </p>";
            }
            ?>
        </div>

        <!-- My Accepted Rides -->
        <div class="card">
            <h2 class="card-title">My Accepted Rides</h2>

            <?php
            $driver_id = 1; // Your driver ID

            $sql = "SELECT 
                Ride.Ride_ID,
                Passenger.Passenger_Name,
                Ride.Pickup_Location,
                Ride.Destination,
                Ride.Ride_Date,
                Ride.Pickup_Time,
                Ride.Fare,
                Ride.Ride_Status
            FROM Ride
            INNER JOIN Passenger ON Ride.Passenger_ID = Passenger.Passenger_ID
            WHERE Ride.Driver_ID = $driver_id AND Ride.Ride_Status != 'Cancelled'
            ORDER BY Ride.Ride_ID DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Passenger</th>
                        <th>Pickup</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Fare</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>";

                while($row = $result->fetch_assoc()) {
                    $status_color = $row['Ride_Status'] == 'Accepted' ? '#f39c12' : '#2ecc71';
                    
                    // Only show complete button if status is Accepted
                    $action = '';
                    if ($row['Ride_Status'] == 'Accepted') {
                        $action = "<a href='complete_ride.php?id=" . $row['Ride_ID'] . "' 
                                   onclick='return confirm(\"Mark this ride as completed?\")' 
                                   style='color: #3498db; text-decoration: none; font-weight: 600;'>
                                   ✅ Complete</a>";
                    } else {
                        $action = "<span style='color: #95a5a6;'>—</span>";
                    }

                    echo "<tr>
                        <td>" . $row["Ride_ID"] . "</td>
                        <td>" . $row["Passenger_Name"] . "</td>
                        <td>" . $row["Pickup_Location"] . "</td>
                        <td>" . $row["Destination"] . "</td>
                        <td>" . $row["Ride_Date"] . "</td>
                        <td>" . $row["Pickup_Time"] . "</td>
                        <td>Rs. " . $row["Fare"] . "</td>
                        <td style='color: $status_color; font-weight: 600;'>" . $row["Ride_Status"] . "</td>
                        <td>" . $action . "</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center; color: #6c757d; padding: 20px;'>
                        No rides accepted yet.
                      </p>";
            }

            $conn->close();
            ?>
        </div>

    </div>
</body>
</html>