<?php
// Include database connection
include '../login/dbconfig.php';

// Check if the ID is provided via POST
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo "<script>alert('Gallery ID is required'); window.location.href='your_gallery_page.php';</script>";
    exit;
}

// Get the gallery ID
$galleryId = mysqli_real_escape_string($conn, $_POST['id']);

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Get all images for this category
    $imageQuery = "SELECT image_path FROM gallery_images WHERE category_id = '$galleryId'";
    $imageResult = mysqli_query($conn, $imageQuery);
    
    if ($imageResult) {
        while ($row = mysqli_fetch_assoc($imageResult)) {
            // Delete the actual image file from the server
            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $row['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // Delete images associated with this category
    $deleteImagesQuery = "DELETE FROM gallery_images WHERE category_id = '$galleryId'";
    mysqli_query($conn, $deleteImagesQuery);

    // Delete the gallery category
    $deleteCategoryQuery = "DELETE FROM gallery_categories WHERE id = '$galleryId'";
    mysqli_query($conn, $deleteCategoryQuery);

    // Commit the transaction
    mysqli_commit($conn);

    // Show success message and redirect
    echo "<script>alert('Gallery and all associated images deleted successfully'); window.location.href='uploadGalleryimage.php';</script>";
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='uploadGalleryimage.php';</script>";
}

// Close connection
mysqli_close($conn);
?>
