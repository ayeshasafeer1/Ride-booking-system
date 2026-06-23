<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $ride_id = $_GET['id'];
    
    $sql = "UPDATE Ride SET Ride_Status = 'Cancelled' WHERE Ride_ID = $ride_id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: my_rides.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>