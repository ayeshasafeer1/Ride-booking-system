<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

// Collect Form Data
$passenger_name = $_POST['passenger_name'];
$phone          = $_POST['phone'];
$pickup         = $_POST['pickup'];
$destination    = $_POST['destination'];
$ride_date      = $_POST['ride_date'];
$pickup_time    = $_POST['pickup_time'];
$fare           = $_POST['fare'];

// Insert Passenger
$passenger_sql = "INSERT INTO Passenger (Passenger_Name, Phone)
VALUES ('$passenger_name', '$phone')";

if (!$conn->query($passenger_sql)) {
    die("Passenger insert failed: " . $conn->error);
}

$passenger_id = $conn->insert_id;

// Get Driver safely
$driver_result = $conn->query("SELECT Driver_ID FROM Driver ORDER BY RAND() LIMIT 1");

if ($driver_result->num_rows == 0) {
    die("No drivers found in database");
}

$driver = $driver_result->fetch_assoc();
$driver_id = $driver['Driver_ID'];

// Insert Ride
$ride_sql = "INSERT INTO Ride
(Pickup_Location, Destination, Ride_Date, Pickup_Time, Fare, Ride_Status, Passenger_ID, Driver_ID)
VALUES
('$pickup', '$destination', '$ride_date', '$pickup_time', '$fare', 'Booked', '$passenger_id', '$driver_id')";

if ($conn->query($ride_sql) === TRUE) {
    // Changed: Now goes to my_rides.php instead of index.php
    header("Location: my_rides.php?success=1");
    exit();
} else {
    die("Ride insert failed: " . $conn->error);
}

$conn->close();
?>