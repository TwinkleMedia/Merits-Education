<?php
include '../login/dbconfig.php'; // Include database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get image path
    $stmt = $conn->prepare("SELECT image_path FROM slider_images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    // Delete image file from server
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete record from database
    $stmt = $conn->prepare("DELETE FROM slider_images WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Image deleted successfully!'); window.location.href='uploadSlider.php';</script>";
    } else {
        echo "<script>alert('Failed to delete image.');</script>";
    }
    $stmt->close();
}
?>
