<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gallery - Merit Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./page.css">
</head>

<body>
   
    <!-- Mobile Overlay -->
    <div class="mobile-overlay"></div>

    <div class="wrapper">
        <!-- Include the sidebar -->
        <?php include '../sidenavbar/sidenavbar.php'; ?>

        <!-- Content Area -->
        <div class="content">
            <h2 class="text-center mb-4">Upload Gallery</h2>

            <!-- Upload Form -->
            <div class="row mb-4">
                <div class="col-lg-8 col-md-10 col-12 mx-auto">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="text-center m-0 fs-5"><i class="fas fa-images me-2"></i>Add New Gallery Category</h3>
                        </div>
                        <div class="card-body">
                            <form action="GalleryUpload.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="category" name="category" required>
                                </div>
                                <div class="mb-3">
                                    <label for="images" class="form-label">Upload Images (Min 1 - Max 10)</label>
                                    <input type="file" class="form-control" id="images" name="images[]" multiple required accept="image/*" onchange="validateFiles()">
                                    <div class="form-text text-muted">Select up to 10 images for this category</div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-upload me-2"></i>Upload Gallery
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Categories Table -->
            <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Preview</th>
            <th>Date Added</th>
            <th>Total Images</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../login/dbconfig.php';
        $query = "SELECT g.id, g.category_name, g.created_at, 
                (SELECT COUNT(*) FROM gallery_images gi WHERE gi.category_id = g.id) as image_count,
                (SELECT image_path FROM gallery_images gi WHERE gi.category_id = g.id LIMIT 1) as preview_image
                FROM gallery_categories g
                ORDER BY g.created_at DESC";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['category_name'] . '</td>';
                echo '<td><img src="' . $row['preview_image'] . '" alt="Preview" width="50" height="50" class="img-thumbnail"></td>';
                echo '<td>' . date('M d, Y', strtotime($row['created_at'])) . '</td>';
                echo '<td>' . $row['image_count'] . '</td>';
                echo '<td>
                        <form method="POST" action="deleteGallery.php" onsubmit="return confirm(\'Are you sure you want to delete this gallery?\');">
                            <input type="hidden" name="id" value="' . $row['id'] . '">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6" class="text-center">No gallery categories found</td></tr>';
        }
        mysqli_close($conn);
        ?>
    </tbody>
</table>

            </div>
        </div>
    </div>
    <script >
         // Desktop Toggle
         const toggleBtn = document.querySelector('.toggle-btn');
     const sidebar = document.querySelector('.sidebar');
     const content = document.querySelector('.content');

     toggleBtn.addEventListener('click', () => {
         sidebar.classList.toggle('collapsed');
         // Store sidebar state in localStorage
         localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
     });

     // Mobile Toggle
     const mobileToggle = document.querySelector('.mobile-toggle');
     const mobileOverlay = document.querySelector('.mobile-overlay');

     function toggleMobile() {
         sidebar.classList.toggle('mobile-active');
         mobileOverlay.classList.toggle('active');
         document.body.classList.toggle('overflow-hidden');
     }

     mobileToggle.addEventListener('click', toggleMobile);
     mobileOverlay.addEventListener('click', toggleMobile);

     // Close mobile menu when clicking a link
     const navLinks = document.querySelectorAll('.nav-link');
     navLinks.forEach(link => {
         link.addEventListener('click', () => {
             if (window.innerWidth <= 768 && sidebar.classList.contains('mobile-active')) {
                 toggleMobile();
             }
             
             // Set active class
             navLinks.forEach(l => l.classList.remove('active'));
             link.classList.add('active');
         });
     });

     // Check for saved sidebar state
     document.addEventListener('DOMContentLoaded', () => {
         const savedState = localStorage.getItem('sidebarCollapsed');
         if (savedState === 'true') {
             sidebar.classList.add('collapsed');
         }
     });

     // Responsive adjustments on window resize
     window.addEventListener('resize', () => {
         if (window.innerWidth > 768 && sidebar.classList.contains('mobile-active')) {
             sidebar.classList.remove('mobile-active');
             mobileOverlay.classList.remove('active');
             document.body.classList.remove('overflow-hidden');
         }
     });
   </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>