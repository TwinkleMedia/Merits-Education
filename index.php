<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merits with Iitians`s Hub Conducts</title>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

    <?php include 'link.php';?>
</head>
<body>

<?php include './header/navbar.php';?>
<!-- --------------------Hero Section--------------------- -->
<?php
include './dbconnuser.php'; // Include your database connection file

$query = "SELECT image_path FROM slider_images ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $query);
?>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php
    $active = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $imagePath = './admin/pages/' . $row['image_path']; // Ensure correct path
        ?>
        <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
            <img src="<?php echo $imagePath; ?>" class="d-block w-100" alt="Slider Image">
        </div>
        <?php
        $active = false;
    }
    ?>
  </div>
</div>

  </div>
</div>


<!-- ------------------next section--------------- -->
<div class="container mt-5">
    <div class="row g-3">
        <div class="col-md-4">   
            <div class="feature-box">
                <img src="icon1.png" alt="icon">
                <p><strong>6<sup>th</sup> to 12<sup>th</sup></strong> All Subjects State Board | CBSE | ICSE | IGCSE | STATE Boards</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <img src="icon2.png" alt="icon">
                <p><strong>6<sup>th</sup> & 12<sup>th</sup></strong> Science & Commerce</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <img src="icon3.png" alt="icon">
                <p><strong>11<sup>th</sup> & 12<sup>th</sup></strong> INTEGRATED JEE, NEET & BOARD</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <img src="icon4.png" alt="icon">
                <p><strong>LEARN LANGUAGES (ONE TO ONE) / BATCH</strong> </p>
                <div class="d-flex justify-content"><li>German</li> <li>Japanese</li> <li>Asdvanced English</li></div>
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <img src="icon5.png" alt="icon">
                <p><strong>Career Prep</strong> Extensive Training of UG-ENTRANCE EXAMS for BBA,BMS, HM, CLAT, SM</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <img src="icon6.png" alt="icon">
                <p><strong>All Subjects Inculding  COMPUTERS / AI</strong><br>CBSE, ICSE, IGCSE, STATE Boards</p>
            </div>
        </div>
    </div>
</div>


<!-- ----------------Special annoucement -->

<!-- Special Announcement Button -->

<button id="openPopup" class="btn btn-primary d-flex align-items-center">
        <i class="fa fa-bullhorn me-2"></i> Special Announcement
    </button>

    <!-- Popup Modal -->
    <div id="popup" class="popup-overlay">
        <div class="popup-box">
            <span class="popup-close">&times;</span>
            <div class="feature-box">
                
            <p><strong>Prime Batch :</strong>5 Students</p>
            <p><strong>Regular Batch :</strong>15 Students</p>
            <li>Genius Batch for `Scholars`</li>
            <li>Remedial Batch for `Struggling Students`</li>
            </div>
            <a href="" class="btn">Enrol Now</a>
        </div>
    </div>
    

    <!-- ----About us  -->
    <div class="container">
    <div class="row about-section align-items-center">
        <div class="col-12 col-md-6 about-img">
            <img src="./assest/image-frame-img-1.jpg" alt="About Us">
        </div>
        <div class="col-12 col-md-6 about-text">
            <h2>About Us <span>THE IITIAN'S HUB</span></h2>
            <p>We are dedicated to providing top-notch services with a focus on quality, innovation, and customer satisfaction. Our team of experts ensures that every project is executed with precision and professionalism.</p>
            <p>With years of experience in the industry, we have built a reputation for excellence and trust. Join us on our journey to create something remarkable.</p>
        </div>
    </div>
</div>

<!-- -------------Why Choose us-------------- -->

<div class="container why-choose-us">
    <h2>Why Choose Us</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="icon-box">
                <i class="fas fa-graduation-cap"></i>
                <h5>Nurturing Education Since 1995</h5>
                <p>Over 25 years of excellence in education.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
                <h5>Proven Student Results</h5>
                <p>Consistently high academic achievements.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="icon-box">
                <i class="fas fa-chalkboard-teacher"></i>
                <h5>Best Faculty Members</h5>
                <p>Experienced and passionate educators.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="icon-box">
                <i class="fas fa-book"></i>
                <h5>Quality Study Material</h5>
                <p>Comprehensive and up-to-date resources.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="icon-box">
                <i class="fas fa-user-check"></i>
                <h5>Personalized Coaching</h5>
                <p>Tailored guidance for every student.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="icon-box">
                <i class="fas fa-lightbulb"></i>
                <h5>Innovative Teaching Methodology</h5>
                <p>Modern and effective learning techniques.</p>
            </div>
        </div>
    </div>
</div>

<!-- -------------------------------Count section-------- -->

<div class="container my-5">
    <div class="row text-center">
        <div class="col-md-4">
            <a href="#" class="text-decoration-none">

            
            <div class="stats-box">
                <i class="fas fa-book-open"></i>
                <div class="stats-number" data-count="87411"></div>
                <div class="stats-title">Practice Questions</div>
                <div class="stats-text">A vast collection of questions to test your knowledge.</div>
            </div>
            </a>
        </div>
        
        <div class="col-md-4">
        <a href="#" class="text-decoration-none">
        <div class="stats-box">
                <i class="fas fa-tasks"></i>
                <div class="stats-number" data-count="936">0</div>
                <div class="stats-title">Assignments</div>
                <div class="stats-text">Various online and offline assignments for assessment.</div>
            </div>
</a>
            
        </div>
        <div class="col-md-4">
            <a href="./recordedlectures.php" class="text-decoration-none">
            <div class="stats-box">
                <i class="fas fa-video"></i>
                <div class="stats-number" data-count="25729">0</div>
                <div class="stats-title">Recorded Lectures</div>
                <div class="stats-text">Access recorded video lectures to revise your lessons.</div>
            </div>
            </a>
            
        </div>
    </div>
</div>
<!-- -----------gallery section   -->
<!-- -----------Gallery Section   -->
<?php
include './dbconnuser.php'; // Include your database connection file

// Fetch categories
$categoriesQuery = "SELECT * FROM gallery_categories";
$categoriesResult = mysqli_query($conn, $categoriesQuery);
?>

<!-- -----------Gallery Section   -->
<div class="container py-5">
    <h2 class="text-center mb-4">Gallery Section</h2>
    
    <!-- Filter buttons -->
    <div class="gallery-filter-container text-center mb-4">
        <div class="filter-buttons d-flex flex-wrap justify-content-center">
            <button class="btn btn-primary filter-btn m-1 active" data-filter="all">All</button>
            <?php
            while ($category = mysqli_fetch_assoc($categoriesResult)) {
                echo '<button class="btn btn-outline-primary filter-btn m-1" data-filter="cat-' . $category['id'] . '">' . $category['category_name'] . '</button>';
            }
            ?>
        </div>
    </div>

    <!-- Gallery grid -->
    <div class="row g-4" id="gallery-grid">
        <?php
        // Fetch gallery images with categories
        $imagesQuery = "SELECT gallery_images.image_path, gallery_images.category_id, gallery_categories.category_name 
                        FROM gallery_images 
                        JOIN gallery_categories ON gallery_images.category_id = gallery_categories.id";
        $imagesResult = mysqli_query($conn, $imagesQuery);

        while ($image = mysqli_fetch_assoc($imagesResult)) {
            echo '<div class="col-6 col-md-4 col-lg-3 gallery-item cat-' . $image['category_id'] . '">';
            echo '  <div class="gallery-card h-100">';
            echo '    <div class="gallery-image-wrapper">';
            echo '      <img src="./admin/pages/' . $image['image_path'] . '" class="img-fluid w-100" alt="Gallery Image" loading="lazy">';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }
        ?>
    </div>
</div>



<!-- ------------------Enquiry Form------------ -->
<div class="container">
    <div class="row enquiry-container">
        <div class="col-md-6 form-image d-none d-md-block"></div>
        <div class="col-md-6 p-4">
            <h3 class="mb-4 text-center">Enquiry Form</h3>
            <form action="enquiry_process.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Standard</label>
                    <input type="text" class="form-control" name="standard" placeholder="Enter your standard" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">School/College</label>
                    <input type="text" class="form-control" name="school_college" placeholder="Enter your school/college" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Board</label>
                    <input type="text" class="form-control" name="board" placeholder="Enter your board" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" class="form-control" name="subject" placeholder="Enter your subject" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact No.</label>
                    <input type="text" class="form-control" name="contact_no" placeholder="Enter your contact number" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- -----------Faq--------------- -->
<div class="container my-5">
        <h2 class="text-center mb-4">Frequently Asked Questions</h2>
        <div class="accordion" id="faqAccordion">
            
            <!-- FAQ Items -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        What courses does Merits Education offer?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We offer coaching for classes 6th to 12th (Science & Commerce) for CBSE, ICSE, IGCSE, and State Boards.
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        Which languages can I learn at Merits Education?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We provide courses in German, Japanese, and Advanced English.
                    </div>
                </div>
            </div>
            
            <!-- More FAQ items -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        What makes Merits Education unique?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Our institute has been providing quality education since 1995 with a highly experienced team of teachers.
                    </div>
                </div>
            </div>

            <!-- Add 12 more FAQ items following the same pattern -->
        </div>
    </div>



<?php include './footer/footer.php';?>

    <?php include 'js.php';?>
</body>
</html>