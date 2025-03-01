<?php
$servername = "localhost";
$username = "root"; // Change if using a different database user
$password = ""; // Set your MySQL password
$dbname = "MeritsEduDB"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
