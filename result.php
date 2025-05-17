<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include './dbconnuser.php';

// Check connection
if ($conn->connect_error) {
    die("<div class='alert alert-danger'>Connection failed: " . $conn->connect_error . "</div>");
}

// Initialize variables
$students = [];
$debug_info = [];

try {
    // Fetch student results
    $sql = "SELECT * FROM student_results WHERE status = 1 ORDER BY upload_time DESC";
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        $debug_info[] = "Found " . count($students) . " student records";
    } else {
        $debug_info[] = "No student records found with status = 1";
    }

    // Debug table info
    $check_table = $conn->query("SHOW TABLES LIKE 'student_results'");
    if ($check_table->num_rows == 0) {
        $debug_info[] = "The table 'student_results' does not exist!";
    } else {
        $count_result = $conn->query("SELECT COUNT(*) as total FROM student_results");
        if ($count_result) {
            $count_row = $count_result->fetch_assoc();
            $debug_info[] = "Total records in student_results table: " . $count_row['total'];
            
            $status_result = $conn->query("SELECT COUNT(*) as active FROM student_results WHERE status = 1");
            $status_row = $status_result->fetch_assoc();
            $debug_info[] = "Records with status = 1: " . $status_row['active'];
        }
    }

} catch (Exception $e) {
    $debug_info[] = "Error: " . $e->getMessage();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./results.css">
   
</head>
<body>
    <!-- Debug Information
    <div class="container mt-3 debug-info">
        <h4>Debug Information:</h4>
        <ul>
            <?php foreach ($debug_info as $info): ?>
                <li><?php echo htmlspecialchars($info); ?></li>
            <?php endforeach; ?>
        </ul>
        <p>SQL Query: <?php echo htmlspecialchars($sql ?? ''); ?></p>
    </div> -->

    <!-- Student Results Showcase Section -->
    <section class="student-results-showcase py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="section-title fw-bold">Outstanding Student Results</h2>
                    <p class="text-muted lead">Celebrating the achievements of our brilliant students</p>
                </div>
            </div>

            <?php if (count($students) > 0): ?>
            <div class="row">
                <?php foreach ($students as $student): ?>
                <div class="col-md-4 mb-4">
                    <div class="student-card h-100">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="ribbon-wrapper">
                                <div class="ribbon"><?php echo htmlspecialchars($student['standard'] ?? 'N/A'); ?></div>
                            </div>
                            <div class="student-image-container text-center py-4">
                                <div class="student-image-wrapper mx-auto">
                                    <?php $image_path = str_replace('./uploads/', './admin/pages/uploads/', $student['image_path']); ?>
                                    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                         alt="<?php echo htmlspecialchars($student['student_name'] ?? 'Student'); ?>" 
                                         class="student-image"
                                         onerror="this.src='https://via.placeholder.com/150'">
                                </div>
                            </div>
                            <div class="card-body text-center pb-4">
                                <h5 class="student-name fw-bold mb-2">
                                    <?php echo htmlspecialchars($student['student_name'] ?? 'Unknown Student'); ?>
                                </h5>
                                
                                <div class="student-info mb-3">
                                    <div class="info-item mb-2">
                                        <span class="info-label">Standard:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($student['standard'] ?? 'N/A'); ?></span>
                                    </div>
                                    
                                    <?php if (isset($student['percentage']) && $student['percentage'] !== null): ?>
                                    <div class="info-item mb-2">
                                        <span class="info-label">Percentage:</span>
                                        <span class="info-value percentage-display">
                                            <?php echo htmlspecialchars($student['percentage']); ?>%
                                            <?php 
                                                $percentageValue = floatval($student['percentage']);
                                                if ($percentageValue >= 90) echo '<i class="fas fa-trophy gold-trophy ms-1" title="Excellent"></i>';
                                                elseif ($percentageValue >= 80) echo '<i class="fas fa-medal silver-medal ms-1" title="Great"></i>';
                                                elseif ($percentageValue >= 70) echo '<i class="fas fa-award bronze-award ms-1" title="Good"></i>';
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <div class="progress percentage-progress mb-3">
                                        <div class="progress-bar" role="progressbar" 
                                            style="width: <?php echo htmlspecialchars($student['percentage']); ?>%;" 
                                            aria-valuenow="<?php echo htmlspecialchars($student['percentage']); ?>" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="student-details mb-0">
                                    <?php
                                    $achievementText = "Good Performance";
                                    $badgeClass = "achievement-badge";
                                    
                                    if (isset($student['percentage'])) {
                                        $percentage = floatval($student['percentage']);
                                        if ($percentage >= 90) {
                                            $achievementText = "Exceptional Performance";
                                            $badgeClass .= " gold";
                                        } elseif ($percentage >= 80) {
                                            $achievementText = "Outstanding Achievement";
                                            $badgeClass .= " silver";
                                        } elseif ($percentage >= 70) {
                                            $achievementText = "Excellent Achievement";
                                            $badgeClass .= " bronze";
                                        }
                                    }
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> mb-2">
                                        <i class="fas fa-trophy me-1"></i> <?php echo $achievementText; ?>
                                    </span>
                                </p>
                                
                                <div class="mt-3">
                                    <div class="d-flex justify-content-center">
                                        <?php
                                        $stars = 5;
                                        if (isset($student['percentage'])) {
                                            $percentage = floatval($student['percentage']);
                                            if ($percentage >= 90) $stars = 5;
                                            elseif ($percentage >= 80) $stars = 4;
                                            elseif ($percentage >= 70) $stars = 3;
                                            elseif ($percentage >= 60) $stars = 2;
                                            else $stars = 1;
                                        }
                                        ?>
                                        <div class="star-ratings">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <?php if ($i < $stars): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- <?php if (isset($student['upload_time'])): ?>
                                <div class="upload-date mt-3">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php echo date('M d, Y', strtotime($student['upload_time'])); ?>
                                    </small>
                                </div>
                                <?php endif; ?> -->
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> No student results available at the moment.
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple initialization - remove carousel complexity for now
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Student results page loaded successfully");
            console.log("Found <?php echo count($students); ?> student records");
            
            // Add any simple interactive elements here if needed
            document.querySelectorAll('.student-card').forEach(card => {
                card.addEventListener('click', function() {
                    this.classList.toggle('shadow-lg');
                });
            });
        });
    </script>
</body>
</html>