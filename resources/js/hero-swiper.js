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
            const counter = document.querySelector('.hero-counter-current');
            if (counter) {
                counter.textContent = String(swiper.realIndex + 1).padStart(2, '0');
            }
        },
    },
});
