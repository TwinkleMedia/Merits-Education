<?php
include './dbconnuser.php'; // Include your database connection file

$query = "SELECT * FROM videos ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Page - Math</title>
    <?php include 'link.php';?>
</head>
<body>
<?php include './header/navbar.php';?>
<div class="page-header">
        <div class="container">
            <h1 class="page-title text-center">Video Lectures</h1>
          
        </div>
    </div>
    <div class="container pb-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col">
                <div class="video-card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['topic']); ?></h5>
                        
                        <!-- Video Player -->
                        <div class="video-frame-container">
                            <div class="ratio ratio-16x9">
                                <?php
                                // Process YouTube URL to ensure proper embed format
                                $video_url = $row['video_link'];
                                
                                // Check if it's a YouTube URL
                                if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                                    // Extract video ID
                                    $video_id = '';
                                    
                                    // Handle youtube.com/watch?v= format
                                    if (strpos($video_url, 'youtube.com/watch?v=') !== false) {
                                        parse_str(parse_url($video_url, PHP_URL_QUERY), $params);
                                        $video_id = $params['v'] ?? '';
                                    }
                                    // Handle youtu.be/ format
                                    elseif (strpos($video_url, 'youtu.be/') !== false) {
                                        $parts = explode('/', $video_url);
                                        $video_id = end($parts);
                                    }
                                    // Handle youtube.com/embed/ format
                                    elseif (strpos($video_url, 'youtube.com/embed/') !== false) {
                                        $parts = explode('/', $video_url);
                                        $video_id = end($parts);
                                    }
                                    
                                    // Construct proper embed URL
                                    if (!empty($video_id)) {
                                        $embed_url = "https://www.youtube.com/embed/{$video_id}?rel=0";
                                    } else {
                                        // Fallback to original URL if parsing failed
                                        $embed_url = $video_url;
                                    }
                                } else {
                                    // Not a YouTube URL, use as is
                                    $embed_url = $video_url;
                                }
                                ?>
                                <iframe 
                                    src="<?= htmlspecialchars($embed_url); ?>" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
                        </div>
                        
                        <div class="video-meta">
                            <i class="fas fa-book"></i>
                            <span><strong>Subject:</strong> <?= htmlspecialchars($row['subject']); ?></span>
                        </div>
                        
                        <div class="video-meta">
                            <i class="fas fa-graduation-cap"></i>
                            <span><strong>Standard:</strong> <?= htmlspecialchars($row['standard']); ?></span>
                        </div>
                        
                        <div class="description-container">
                            <div class="description-text" id="desc-<?= $row['id']; ?>">
                                <?= nl2br(htmlspecialchars($row['description'])); ?>
                            </div>
                            <span class="read-more" data-desc="desc-<?= $row['id']; ?>">Read more</span>
                        </div>
                        
                        <div class="upload-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>Uploaded on <?= date('M d, Y', strtotime($row['created_at'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle the "Read more" functionality
            const readMoreButtons = document.querySelectorAll('.read-more');
            
            readMoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const descId = this.getAttribute('data-desc');
                    const descElement = document.getElementById(descId);
                    
                    if (descElement.classList.contains('expanded')) {
                        descElement.classList.remove('expanded');
                        this.textContent = 'Read more';
                    } else {
                        descElement.classList.add('expanded');
                        this.textContent = 'Read less';
                    }
                });
            });
        });
    </script>

    <?php include 'js.php';?>
</body>
</html>
