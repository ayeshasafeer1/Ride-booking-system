<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

if ($user_type == 'passenger') {
    $sql = "SELECT Passenger_ID as id, Passenger_Name as name, Email, Password 
            FROM Passenger WHERE Email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['Password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_type'] = 'passenger';
            header("Location: passenger_dashboard.php");
            exit();
        }
    }
} else {
    $sql = "SELECT Driver_ID as id, Driver_Name as name, Email, Password 
            FROM Driver WHERE Email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['Password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_type'] = 'driver';
            header("Location: driver_dashboard.php");
            exit();
        }
    }
}

// If login fails
header("Location: login.php?error=1");
exit();

$conn->close();
?>