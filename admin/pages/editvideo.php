<?php
include '../login/dbconfig.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM videos WHERE id = $id");
    $video = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);

    // Fetch the existing data before updating
    $existingQuery = "SELECT * FROM videos WHERE id = $id";
    $existingResult = $conn->query($existingQuery);
    $existingData = $existingResult->fetch_assoc();

    // Get new values, but keep old values if fields are left empty
    $subject = !empty($_POST['subject']) ? mysqli_real_escape_string($conn, $_POST['subject']) : $existingData['subject'];
    $standard = !empty($_POST['standard']) ? mysqli_real_escape_string($conn, $_POST['standard']) : $existingData['standard'];
    $topic = !empty($_POST['topic']) ? mysqli_real_escape_string($conn, $_POST['topic']) : $existingData['topic'];
    $description = !empty($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : $existingData['description'];
    $videoLink = !empty($_POST['video_link']) ? mysqli_real_escape_string($conn, $_POST['video_link']) : $existingData['video_link'];

    // Update query with only changed fields
    $updateQuery = "UPDATE videos SET 
                    subject = '$subject', 
                    standard = '$standard', 
                    topic = '$topic', 
                    description = '$description', 
                    video_link = '$videoLink' 
                    WHERE id = $id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Video updated successfully!'); window.location.href='uploadvideo.php';</script>";
    } else {
        echo "Error: " . $updateQuery . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Video</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $video['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" value="<?php echo $video['subject']; ?>" >
        </div>

        <div class="mb-3">
            <label class="form-label">Standard</label>
            <input type="text" class="form-control" name="standard" value="<?php echo $video['standard']; ?>" >
        </div>

        <div class="mb-3">
            <label class="form-label">Topic</label>
            <input type="text" class="form-control" name="topic" value="<?php echo $video['topic']; ?>" >
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description"><?php echo $video['description']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Update Video Link</label>
            <input type="text" class="form-control" name="video_link" value="<?php echo $video['video_link']; ?>" >
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
