<?php

$servername = "localhost";
$username = "root";
$password = "Host@2017";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT * FROM products";
$res = mysqli_query($conn,$sql)
?> 
