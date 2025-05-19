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
    <!-- jQuery (required for Slick) - MOVED TO HEAD -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link rel="stylesheet" href="./results.css">
    
    <style>
        /* Custom styles for student slider */
        .student-slider {
            padding: 20px 50px;
            position: relative;
        }
        
        .student-card {
            transition: all 0.3s ease;
            margin: 10px;
        }
        
        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        
        .student-image-wrapper {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #f8f9fa;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .student-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .ribbon-wrapper {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1;
        }
        
        .ribbon {
            background-color: #5e72e4;
            color: white;
            padding: 5px 15px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .achievement-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            background-color: #f1f3f9;
            color: #5e6c84;
        }
        
        .achievement-badge.gold {
            background-color: #fef7e6;
            color: #daa520;
        }
        
        .achievement-badge.silver {
            background-color: #f1f3f6;
            color: #a9a9a9;
        }
        
        .achievement-badge.bronze {
            background-color: #fcf0e6;
            color: #cd7f32;
        }
        
        .star-ratings {
            color: #ffc107;
        }
        
        .slick-prev, 
        .slick-next {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1;
        }
        
        .slick-prev:before, 
        .slick-next:before {
            color: #5e72e4;
            opacity: 1;
        }
        
        .slick-dots li button:before {
            font-size: 12px;
            color: #5e72e4;
        }
        
        .progress-bar {
            background-color: #5e72e4;
            border-radius: 5px;
        }
        
        .info-label {
            font-weight: 600;
            color: #5e6c84;
        }
        
        .info-value {
            font-weight: 500;
        }
        
        .percentage-display {
            font-size: 16px;
            font-weight: 700;
        }
        
        .gold-trophy {
            color: #daa520;
        }
        
        .silver-medal {
            color: #a9a9a9;
        }
        
        .bronze-award {
            color: #cd7f32;
        }
        
        @media (max-width: 767.98px) {
            .student-slider {
                padding: 10px 30px;
            }
            
            .student-image-wrapper {
                width: 120px;
                height: 120px;
            }
        }
        
        /* Add to ensure slider is visible during debugging */
        .slick-list {
            overflow: visible !important;
        }
    </style>
</head>
<body>
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
            <div class="student-slider">
                <?php foreach ($students as $student): ?>
                <div class="slider-item">
                    <div class="student-card h-100">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="ribbon-wrapper">
                                <div class="ribbon"><?php echo htmlspecialchars($student['standard'] ?? 'N/A'); ?></div>
                            </div>
                            <div class="student-image-container text-center py-4">
                                <div class="student-image-wrapper mx-auto">
                                    <?php 
                                    // Fix the image path by correctly replacing the database path with the actual server path
                                    $image_path = '';
                                    if (isset($student['image_path'])) {
                                        // Ensure we're dealing with the expected format from the database
                                        if (strpos($student['image_path'], './uploads/') === 0) {
                                            // This creates the correct path relative to the current file
                                            $image_path = str_replace('./uploads/', './admin/pages/uploads/', $student['image_path']);
                                        } else {
                                            // If the path doesn't have the expected format, use it as is
                                            $image_path = $student['image_path'];
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo htmlspecialchars($image_path); ?>" 
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
    <!-- Slick Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    
    <script>
        // Ensure jQuery is loaded before attempting to use it
        window.addEventListener('load', function() {
            // Check if jQuery is loaded
            if (typeof jQuery === 'undefined') {
                console.error('jQuery is not loaded!');
                // Try to load jQuery dynamically
                var script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js';
                script.onload = initSlider;
                document.head.appendChild(script);
            } else {
                console.log('jQuery is loaded. Version: ' + jQuery.fn.jquery);
                // Initialize slider when everything is fully loaded
                initSlider();
            }
        });

        function initSlider() {
            console.log('Initializing slider...');
            
            // Make sure slick is available
            if (typeof jQuery.fn.slick === 'undefined') {
                console.error('Slick is not loaded!');
                return;
            }
            
            // Force reflow to ensure DOM is ready
            $('.student-slider')[0].offsetHeight;
            
            // Initialize slider with a small delay to ensure DOM is ready
            setTimeout(function() {
                try {
                    $('.student-slider').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 3000,
                        dots: true,
                        arrows: true,
                        infinite: true,
                        pauseOnHover: true,
                        responsive: [
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: false
                                }
                            }
                        ]
                    });
                    
                    console.log('Slick initialized successfully');
                    
                    // Manually trigger autoplay if needed
                    setTimeout(function() {
                        $('.student-slider').slick('slickPlay');
                        console.log('Manually triggered slick play');
                    }, 1000);
                    
                    // Add animation effect on card hover
                    $('.student-card').hover(
                        function() {
                            $(this).addClass('shadow-lg').css('transform', 'translateY(-10px)');
                        },
                        function() {
                            $(this).removeClass('shadow-lg').css('transform', 'translateY(0)');
                        }
                    );
                    
                    // Add custom class to slick dots
                    $('.slick-dots').addClass('mt-4');
                } catch (e) {
                    console.error('Error initializing slick: ', e);
                }
            }, 500);
        }
        
        // Add this to debug any issues with slider visibility
        function checkSliderVisibility() {
            console.log('Student slider count: ' + $('.student-slider .slider-item').length);
            console.log('Slider visibility: ' + ($('.student-slider').is(':visible') ? 'visible' : 'hidden'));
            console.log('Slider width: ' + $('.student-slider').width());
            console.log('Slider height: ' + $('.student-slider').height());
        }
        
        // Run visibility check after a delay
        setTimeout(checkSliderVisibility, 2000);
    </script>
</body>
</html>