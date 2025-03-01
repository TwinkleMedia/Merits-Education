<?php
// Include database configuration
include '../login/dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    // Ensure at least one file is uploaded
    if (!empty($_FILES['images']['name'][0])) {
        $imageCount = count($_FILES['images']['name']);
        if ($imageCount > 10) {
            die("You can upload a maximum of 10 images.");
        }
        
        // Insert category into database
        $stmt = $conn->prepare("INSERT INTO gallery_categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $category_id = $stmt->insert_id;
        $stmt->close();
        
        $uploadDir = "uploads/gallery/";
        
        foreach ($_FILES['images']['name'] as $key => $imageName) {
            $imageTmpName = $_FILES['images']['tmp_name'][$key];
            $imagePath = $uploadDir . uniqid() . "_" . basename($imageName);
            
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $stmt = $conn->prepare("INSERT INTO gallery_images (category_id, image_path) VALUES (?, ?)");
                $stmt->bind_param("is", $category_id, $imagePath);
                $stmt->execute();
                $stmt->close();
            }
        }
        
        echo "<script>alert('Gallery uploaded successfully!'); window.location.href='uploadGalleryimage.php';</script>";
    } else {
        echo "<script>alert('Please upload at least one image.'); window.history.back();</script>";
    }
}
$conn->close();