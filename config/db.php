<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

// Connection check
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// mysqli_set_charset($conn, "utf8mb4");
