<?php
include 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        $cancel_button = '';
        if ($row['Ride_Status'] != 'Cancelled') {
            $cancel_button = "<a href='cancel_ride.php?id=" . $row['Ride_ID'] . "' 
                             onclick='return confirm(\"⚠️ Cancel Ride #" . $row['Ride_ID'] . "?\\n\\nAre you sure you want to cancel this booking?\\nThis action cannot be undone.\")' 
                             style='color: #e74c3c; text-decoration: none; font-weight: 600;'>
                             ✕ Cancel</a>";
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
            <td>" . $row["Ride_Status"] . "</td>
            <td>" . $cancel_button . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "No rides found.";
}

$conn->close();
?>