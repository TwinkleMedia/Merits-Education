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