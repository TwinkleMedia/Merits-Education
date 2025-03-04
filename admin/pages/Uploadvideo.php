<?php
include '../login/dbconfig.php'; // Include database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $standard = mysqli_real_escape_string($conn, $_POST['standard']);
    $topic = mysqli_real_escape_string($conn, $_POST['topic']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $videoLink = mysqli_real_escape_string($conn, $_POST['videoLink']);

    // Insert data into database
    $insertQuery = "INSERT INTO videos (subject, standard, topic, description, video_link) 
                    VALUES ('$subject', '$standard', '$topic', '$description', '$videoLink')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Video uploaded successfully!'); window.location.href='uploadvideo.php';</script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

// Delete video logic
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM videos WHERE id = $id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Video deleted successfully!'); window.location.href='uploadvideo.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch video records
$videos = $conn->query("SELECT * FROM videos ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Video Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- No need to include sidebar CSS as it will be part of the included file -->
  <link rel="stylesheet" href="./page.css">
</head>
<body>
    <button class="mobile-toggle d-md-none">
        <i class="fas fa-bars"></i>
    </button>
   <!-- Mobile Overlay -->
   <div class="mobile-overlay"></div>
    <div class="wrapper">

            <?php include '../sidenavbar/sidenavbar.php'; ?>
    

        <div class="content">
        
                <div class="form-container mx-auto">
                    <h2 class="text-center mb-4">Upload Video</h2>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="standard" class="form-label">Standard</label>
                            <input type="text" class="form-control" id="standard" name="standard" required>
                        </div>
                        <div class="mb-3">
                            <label for="topic" class="form-label">Topic</label>
                            <input type="text" class="form-control" id="topic" name="topic" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="videoLink" class="form-label">YouTube Video Link</label>
                            <input type="text" class="form-control" id="videoLink" name="videoLink" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                
            </div>
            
        
                <h3 class="text-center mb-4">Uploaded Videos</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Standard</th>
                                <th>Topic</th>
                                <th>Description</th>
                                <th>Video Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $videos->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($row['standard']); ?></td>
                                    <td><?php echo htmlspecialchars($row['topic']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td><a href="<?php echo htmlspecialchars($row['video_link']); ?>" target="_blank">Watch</a></td>
                                    <td>
                                        <a href="editvideo.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="uploadvideo.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
          
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
