<?php
include '../login/dbconfig.php'; // Include your database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel - Upload Slider</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./page.css">
</head>


<body>
    <button class="mobile-toggle d-md-none">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay"></div>

    <div class="wrapper">
        <!-- Include the sidebar -->
        <?php include '../../../Merits-Education/admin/sidenavbar/sidenavbar.php'; ?>

        <!-- Content Area -->
        <div class="content">
            <h2 class="mb-4">Upload Slider Image</h2>

            <!-- Slider Upload Form -->
            <form action="sliderupload.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="sliderImage" class="form-label">Select Slider Image:</label>
                    <input type="file" class="form-control" name="sliderImage" id="sliderImage" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload Image</button>
            </form>

            <!-- Table to display slider images -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="8%">ID</th>
                            <th width="45%">Image</th>
                            <th width="27%">Uploaded At</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM slider_images ORDER BY uploaded_at DESC";
                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td class='text-center'>
                                            <img src='{$row['image_path']}' class='img-thumbnail' alt='Slider Image {$row['id']}'>
                                        </td>
                                        <td>" . date('M d, Y h:i A', strtotime($row['uploaded_at'])) . "</td>
                                        <td>
                                            <a href='delete_slider.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this image?\");'>
                                                <i class='bi bi-trash me-1'></i> Delete
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='4' class='text-center'>No Slider Images Found</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <script src="../sidenavbar/sidenavbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>