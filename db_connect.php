<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "ride_booking_system"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
```
