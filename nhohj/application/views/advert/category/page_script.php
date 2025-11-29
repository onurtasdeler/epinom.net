<script>
    var swiper = new Swiper(".news-carousel .mySwiper", {
        slidesPerView: 3,
        spaceBetween: 20,
        loop: true,
        parallax: true,
        speed: 1000,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
        navigation: {
            nextEl: ".section-title .button .right",
            prevEl: ".section-title .button .left",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        }
    });
</script>