<?php
include './dbconnuser.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $standard = mysqli_real_escape_string($conn, $_POST['standard']);
    $school_college = mysqli_real_escape_string($conn, $_POST['school_college']);
    $board = mysqli_real_escape_string($conn, $_POST['board']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);

    // Insert data into the database
    $sql = "INSERT INTO enquiries (name, standard, school_college, board, subject, contact_no) 
            VALUES ('$name', '$standard', '$school_college', '$board', '$subject', '$contact_no')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Enquiry submitted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
