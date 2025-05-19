<?php 
include '../login/dbconfig.php'; // Include your database connection

// Process form submission
if (isset($_POST['submit'])) {
    $student_name = $_POST['student_name'];
    $standard = $_POST['standard'];
    $percentage = $_POST['percentage'];
    $upload_time = date('Y-m-d H:i:s');
    
    // File upload handling
    $target_dir = "./uploads/students/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_name = basename($_FILES["student_image"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is an actual image
    if (isset($_FILES["student_image"]["tmp_name"])) {
        $check = getimagesize($_FILES["student_image"]["tmp_name"]);
        if ($check === false) {
            $upload_error = "File is not an image.";
            $upload_ok = 0;
        }
    } else {
        $upload_error = "Please select an image file.";
        $upload_ok = 0;
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES["student_image"]["size"] > 5000000) {
        $upload_error = "Sorry, your file is too large. Max size is 5MB.";
        $upload_ok = 0;
    }
    
    // Allow only certain file formats
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg") {
        $upload_error = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $upload_ok = 0;
    }
    
    // If everything is ok, try to upload file and save to database
    if ($upload_ok == 1) {
        if (move_uploaded_file($_FILES["student_image"]["tmp_name"], $target_file)) {
            $image_path = str_replace('../', '', $target_file); // Store relative path in DB
            
            // Insert into database
            $sql = "INSERT INTO student_results (student_name, standard, percentage, image_path, upload_time) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdss", $student_name, $standard, $percentage, $image_path, $upload_time);
            
            if ($stmt->execute()) {
                $success_message = "Student result uploaded successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error_message = $upload_error;
    }
}

// Process delete request
// Process delete request
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // First get the image path to delete the file
    $sql = "SELECT image_path FROM student_results WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $error_message = "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_path = $row['image_path'];
            
            // Delete the record from database
            $delete_sql = "DELETE FROM student_results WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            
            if (!$delete_stmt) {
                $error_message = "Prepare failed: " . $conn->error;
            } else {
                $delete_stmt->bind_param("i", $delete_id);
                
                if ($delete_stmt->execute()) {
                    // Try to delete the image file
                    $full_image_path = "../" . $image_path;
                    
                    // For debugging - add this temporarily
                    // $error_message = "Path: " . $full_image_path;
                    
                    if (file_exists($full_image_path)) {
                        if (unlink($full_image_path)) {
                            $success_message = "Student record and image deleted successfully!";
                        } else {
                            $success_message = "Student record deleted but failed to delete image file.";
                        }
                    } else {
                        $success_message = "Student record deleted successfully! (Image file not found)";
                    }
                } else {
                    $error_message = "Error deleting record: " . $delete_stmt->error;
                }
                
                $delete_stmt->close();
            }
        } else {
            $error_message = "Record not found!";
        }
        
        $stmt->close();
    }}
// Fetch all student results
$sql = "SELECT * FROM student_results ORDER BY upload_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel - Upload Student Result</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <div class="container-fluid py-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="fw-bold"><i class="fas fa-graduation-cap me-2"></i>Upload Student Result</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Upload Student Result</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Student Result Details</h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="student_name" class="form-label required">Name of Student</label>
                                        <input type="text" class="form-control" id="student_name" name="student_name" required placeholder="Enter student's full name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="standard" class="form-label required">Standard of Student</label>
                                        <input type="text" class="form-control" id="standard" name="standard" required placeholder="Enter student's standard (e.g., 12th)">
                                        <small class="text-muted">Example format: 1st, 2nd, 3rd, ... 12th</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="percentage" class="form-label required">Percentage</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="percentage" name="percentage" required placeholder="Enter student's percentage" min="0" max="100" step="0.01">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <small class="text-muted">Enter the overall percentage achieved by the student (0-100)</small>
                                    </div>

                                    <div class="mb-4">
                                        <label for="student_image" class="form-label required">Student Image</label>
                                        <input type="file" class="form-control" id="student_image" name="student_image" required accept="image/jpeg, image/png, image/jpg">
                                        <small class="text-muted">Upload student photo (JPG, JPEG, or PNG format, max 5MB)</small>
                                        <div class="mt-2">
                                            <img id="preview" class="preview-image mt-2" alt="Image Preview" />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-undo me-1"></i> Reset
                                        </button>
                                        <button type="submit" name="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Upload Result
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Student Results Table -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Student Results</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Standard</th>
                                                <th>Percentage</th>
                                                <th>Uploaded</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($result->num_rows > 0): ?>
                                                <?php while($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td>
                                                        <img src="../<?php echo htmlspecialchars($row['image_path']); ?>" alt="Student" class="student-img">
                                                    </td>
                                                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['standard']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['percentage']); ?>%</td>
                                                    <td><?php echo date('M j, Y', strtotime($row['upload_time'])); ?></td>
                                                    <td>
                                                        <button class="delete-btn" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No student results found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Instructions</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-check-circle text-success me-2"></i> Enter the student's full name
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-check-circle text-success me-2"></i> Enter the standard (e.g., 12th)
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-check-circle text-success me-2"></i> Enter the percentage achieved by the student
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-check-circle text-success me-2"></i> Upload a clear image of the student
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i> Image must be in JPG, JPEG, or PNG format
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i> Maximum file size: 5MB
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <script>
    // Image preview functionality
    document.getElementById('student_image').addEventListener('change', function() {
        const preview = document.getElementById('preview');
        const file = this.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Delete confirmation function
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this student record? This action cannot be undone.")) {
            window.location.href = "?delete_id=" + id;
        }
    }

    // Set up sidebar functionality after DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        // Desktop Toggle
        const toggleBtn = document.querySelector('.toggle-btn');
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                // Store sidebar state in localStorage
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        }

        // Mobile Toggle
        const mobileToggle = document.querySelector('.mobile-toggle');
        const mobileOverlay = document.querySelector('.mobile-overlay');

        function toggleMobile() {
            sidebar.classList.toggle('mobile-active');
            mobileOverlay.classList.toggle('active');
            document.body.classList.toggle('overflow-hidden');
        }

        if (mobileToggle && mobileOverlay) {
            mobileToggle.addEventListener('click', toggleMobile);
            mobileOverlay.addEventListener('click', toggleMobile);
        }

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
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true' && sidebar) {
            sidebar.classList.add('collapsed');
        }
    });

    // Responsive adjustments on window resize
    window.addEventListener('resize', () => {
        const sidebar = document.querySelector('.sidebar');
        const mobileOverlay = document.querySelector('.mobile-overlay');
        
        if (window.innerWidth > 768 && sidebar && sidebar.classList.contains('mobile-active')) {
            sidebar.classList.remove('mobile-active');
            if (mobileOverlay) mobileOverlay.classList.remove('active');
            document.body.classList.remove('overflow-hidden');
        }
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>