<?php
//$servername = "localhost";
// $username = "u694280384_meritsDB1"; // Change if using a different database user
// $password = "meritsDB@2025"; // Set your MySQL password
// $dbname = "u694280384_meritsDB1"; // Database name


$servername = "localhost";
 $username = "root"; // Change if using a different database user
 $password = ""; // Set your MySQL password
 $dbname = "MeritsEduDB"; // Database name
 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
