import Swiper from 'swiper';
import { Autoplay, EffectFade, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';

const el = document.querySelector('.testimonial-swiper');

new Swiper(el, {
    modules: [Autoplay, EffectFade, Pagination],
    effect: 'fade',
    fadeEffect: { crossFade: true },
    loop: true,
    slidesPerView: 1,
    autoHeight: true,
    allowTouchMove: false,
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
            // Respect reduced-motion preferences: don't auto-advance the quotes.
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                swiper.autoplay.stop();
            }
        },
    },
});