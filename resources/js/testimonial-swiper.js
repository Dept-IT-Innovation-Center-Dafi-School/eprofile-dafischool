import Swiper from 'swiper';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

new Swiper('.testimonial-swiper', {
    modules: [Autoplay, Pagination],
    loop: true,
    loopedSlides: 3,
    centeredSlides: true,
    slidesPerView: 1,
    spaceBetween: 24,
    breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
    },
    autoplay: {
        delay: 6000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
    pagination: {
        el: '.testimonial-swiper-pagination',
        clickable: true,
    },
    on: {
        init(swiper) {
            swiper.pagination.update();

            // Respect reduced-motion preferences: don't auto-advance the cards.
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                swiper.autoplay.stop();
            }
        },
    },
});