<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #03214E;
            --secondary-color: #967AA0;
            --text-color: #333;
            --light-color: #fff;
            --transition-speed: 0.3s;
            --hover-bg: rgba(255, 255, 255, 0.15);
            --active-bg: rgba(255, 255, 255, 0.25);
            --danger-hover: rgba(255, 0, 0, 0.2);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(90deg, rgba(0,0,1,1) 0%, rgba(156,19,2,1) 36%);
            color: var(--light-color);
            transition: all var(--transition-speed) ease;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            transition: opacity var(--transition-speed);
            letter-spacing: 0.5px;
        }

        .collapsed .logo-text {
            display: none;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: var(--light-color);
            cursor: pointer;
            padding: 8px;
            font-size: 1.25rem;
            border-radius: 8px;
            transition: background-color var(--transition-speed);
        }

        .toggle-btn:hover {
            background-color: var(--hover-bg);
        }

        .nav-list {
            list-style: none;
            padding: 15px 0;
            margin: 0;
        }

        .nav-item {
            margin: 8px 15px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: var(--light-color);
            text-decoration: none;
            border-radius: 12px;
            transition: all var(--transition-speed);
            position: relative;
        }

        .nav-link:hover {
            background: var(--hover-bg);
            color: var(--light-color);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--active-bg);
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-icon {
            font-size: 1.2rem;
            width: 30px;
            text-align: center;
            transition: transform var(--transition-speed);
        }

        .nav-link:hover .nav-icon {
            transform: scale(1.1);
        }

        .nav-text {
            margin-left: 12px;
            transition: opacity var(--transition-speed);
            white-space: nowrap;
        }

        .collapsed .nav-text {
            display: none;
        }

        /* Logout styles */
        .logout-container {
            position: absolute;
            bottom: 20px;
            width: 100%;
            padding: 0 15px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin: 0;
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: var(--light-color);
            text-decoration: none;
            transition: all var(--transition-speed);
        }

        .logout-btn:hover {
            background: var(--danger-hover);
            color: var(--light-color);
            transform: translateX(5px);
        }

        .logout-btn i {
            font-size: 1.2rem;
            width: 30px;
            text-align: center;
        }

        /* Content area - simplified */
        .content {
            flex: 1;
          
            transition: margin-left var(--transition-speed);
        }

        .collapsed + .content {
            margin-left: 80px;
        }

        /* Mobile overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
            transition: opacity var(--transition-speed);
        }

        .mobile-overlay.active {
            display: block;
        }

        /* Mobile toggle button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: var(--primary-color);
            color: var(--light-color);
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all var(--transition-speed);
        }

        .mobile-toggle:hover {
            transform: scale(1.05);
        }

        /* Tooltip for collapsed state */
        .collapsed .nav-link {
            position: relative;
        }

        .collapsed .nav-link:hover::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: var(--light-color);
            padding: 6px 12px;
            border-radius: 8px;
            margin-left: 15px;
            font-size: 0.85rem;
            white-space: nowrap;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .sidebar {
                width: 240px;
            }
            .content {
                margin-left: 240px;
            }
            .collapsed + .content {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px !important;
            }

            .sidebar.mobile-active {
                transform: translateX(0);
            }

            .content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .toggle-btn.d-none.d-md-block {
                display: none !important;
            }

            .mobile-overlay.active {
                display: block;
            }

            .logo-text, .nav-text {
                display: block !important;
            }
        }

        /* Animation effects */
        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .nav-item {
            animation: slideIn 0.3s ease forwards;
            opacity: 0;
        }

        .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .nav-item:nth-child(5) { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle d-md-none">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay"></div>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <span class="logo-text">Merit Dashboard</span>
                <button class="toggle-btn d-none d-md-block">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="nav-list">
                <li class="nav-item">
                    <a href="../../admin/pages/enquiryGET.php" class="nav-link active" data-title="Enquiry Messages">
                        <i class="nav-icon fas fa-envelope"></i>
                        <span class="nav-text">Enquiry Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../admin/pages/uploadSlider.php" class="nav-link" data-title="Upload Slider">
                        <i class="nav-icon fa fa-sliders"></i>
                        <span class="nav-text">Upload Slider</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../admin/pages/uploadGalleryImage.php" class="nav-link" data-title="Gallery Images">
                        <i class="nav-icon fas fa-images"></i>
                        <span class="nav-text">Upload Gallery Images</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../admin/pages/Uploadvideo.php" class="nav-link" data-title="Upload Videos">
                        <i class="nav-icon fas fa-video"></i>
                        <span class="nav-text">Upload Videos</span>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="../../admin/pages/uploadResult.php" class="nav-link" data-title="Upload Videos">
                       <i class="fa-solid fa-user"></i>
                        <span class="nav-text">Upload Result</span>
                    </a>
                </li>
            </ul>
            
            <!-- Logout Button -->
            <div class="logout-container">
                <a href="./login/logout.php" class="logout-btn" data-title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </div>
        </nav>

        <!-- Content Area will be added separately -->
        <div class="content">
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
</body>
</html>