<!-- Bootsrap File link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<!-- -----------swiper slider -->

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            lazy: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>


<!--  -->

<script>
        // Get elements
        const openPopup = document.getElementById('openPopup');
        const popup = document.getElementById('popup');
        const closePopup = document.querySelector('.popup-close');

        // Open popup
        openPopup.addEventListener('click', () => {
            popup.style.display = 'flex';
        });

        // Close popup on close button
        closePopup.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        // Close popup when clicking outside the box
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.style.display = 'none';
            }
        });
    </script>




<script>
    function animateCountUp(element, target) {
        let start = 0;
        let duration = 2000; // 2 seconds
        let increment = target / (duration / 16); 

        function updateCounter() {
            start += increment;
            if (start >= target) {
                element.innerText = target;
            } else {
                element.innerText = Math.floor(start);
                requestAnimationFrame(updateCounter);
            }
        }
        updateCounter();
    }

    function startCounting() {
        const counters = document.querySelectorAll('.stats-number');
        counters.forEach(counter => {
            let target = parseInt(counter.getAttribute('data-count'));
            animateCountUp(counter, target);
        });
    }

    let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounting();
                observer.disconnect();
            }
        });
    }, { threshold: 0.5 });

    observer.observe(document.querySelector('.container'));
</script>


<!-- --------Gallery---------------- -->
<script>
        document.addEventListener("DOMContentLoaded", function () {
            const filterButtons = document.querySelectorAll(".filter-btn");
            const galleryItems = document.querySelectorAll(".gallery-item");
            
            filterButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const filter = this.getAttribute("data-filter");
                    
                    galleryItems.forEach(item => {
                        if (filter === "all" || item.classList.contains(filter)) {
                            item.classList.add("show");
                        } else {
                            item.classList.remove("show");
                        }
                    });
                });
            });
        });
    </script>