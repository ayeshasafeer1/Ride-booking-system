<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

// Check if email already exists
if ($user_type == 'passenger') {
    $check = $conn->query("SELECT * FROM Passenger WHERE Email = '$email'");
} else {
    $check = $conn->query("SELECT * FROM Driver WHERE Email = '$email'");
}

if ($check->num_rows > 0) {
    die("❌ This email is already registered. <a href='register.php'>Go back</a>");
}

// Insert new user
if ($user_type == 'passenger') {
    $sql = "INSERT INTO Passenger (Passenger_Name, Email, Phone, Password) 
            VALUES ('$name', '$email', '$phone', '$password')";
} else {
    $sql = "INSERT INTO Driver (Driver_Name, Email, Phone, Password) 
            VALUES ('$name', '$email', '$phone', '$password')";
}

if ($conn->query($sql) === TRUE) {
    header("Location: login.php?registered=1");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>