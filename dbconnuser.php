<?php
$servername = "localhost";
$username = "u694280384_meritsDB"; // Change if using a different database user
$password = "meritsDB@2025"; // Set your MySQL password
$dbname = "u694280384_meritsDB"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
