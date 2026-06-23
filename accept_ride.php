<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

if (isset($_GET['id'])) {
    $ride_id = $_GET['id'];
    $driver_id = 1; // Your working driver ID
    
    $sql = "UPDATE Ride SET Driver_ID = $driver_id, Ride_Status = 'Accepted' WHERE Ride_ID = $ride_id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to driver dashboard
        header("Location: driver_dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No ride ID provided";
}

$conn->close();
?>