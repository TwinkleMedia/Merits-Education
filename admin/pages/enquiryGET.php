<?php
include '../login/dbconfig.php'; // Database connection

// Delete functionality
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM enquiries WHERE id = $id";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Enquiry deleted successfully!'); window.location.href='enquiryMessages.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch enquiries
$sql = "SELECT * FROM enquiries ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

