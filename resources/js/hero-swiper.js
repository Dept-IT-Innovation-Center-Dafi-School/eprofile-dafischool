import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

new Swiper('.hero-swiper', {
    modules: [Pagination, Autoplay],
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    grabCursor: true,
    on: {
        slideChange(swiper) {
            // Re-trigger caption animation on slide change
            const caption = swiper.slides[swiper.activeIndex].querySelector('.hero-caption');
            if (caption) {
                caption.style.animation = 'none';
                // Trigger reflow to restart animation
                void caption.offsetWidth;
                caption.style.animation = '';
            }
        },
    },
});
