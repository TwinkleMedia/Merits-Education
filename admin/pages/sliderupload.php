<?php
include '../login/dbconfig.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["sliderImage"]) && $_FILES["sliderImage"]["error"] == 0) {
        $targetDir = "uploads/sliderimage/"; // Folder to store images
        $fileName = basename($_FILES["sliderImage"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowedTypes)) {
            // Move uploaded file to the server directory
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); // Create folder if it doesn't exist
            }
            if (move_uploaded_file($_FILES["sliderImage"]["tmp_name"], $targetFilePath)) {
                // Save image path in the database
                $stmt = $conn->prepare("INSERT INTO slider_images (image_path) VALUES (?)");
                $stmt->bind_param("s", $targetFilePath);
                if ($stmt->execute()) {
                    echo "<script>alert('Image uploaded successfully!'); window.location.href='uploadSlider.php';</script>";
                } else {
                    echo "<script>alert('Database error!');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('File upload failed!');</script>";
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG, & GIF files are allowed.');</script>";
        }
    } else {
        echo "<script>alert('Please select an image.');</script>";
    }
}
?>
