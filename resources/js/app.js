import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

Swiper.use([Pagination, Autoplay]);

window.Swiper = Swiper;

// Initialize hero swiper if element exists
document.addEventListener('DOMContentLoaded', () => {
    const swiperEl = document.querySelector('.hero-swiper');
    if (swiperEl) {
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
        });
    }
});

// Image lightbox — plain DOM, no framework dependency. Any element with
// [data-lightbox-trigger] opens the modal with its data-lightbox-src/-alt.
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('image-lightbox');
    if (!modal) return;

    const img = modal.querySelector('[data-lightbox-image]');
    const spinner = modal.querySelector('[data-lightbox-spinner]');
    const caption = modal.querySelector('[data-lightbox-caption]');
    const TRANSITION_MS = 300;

    const showImage = () => {
        spinner.classList.add('hidden');
        img.classList.remove('opacity-0', 'scale-95');
    };

    const open = (src, alt) => {
        caption.textContent = alt || '';
        caption.classList.toggle('hidden', !alt);

        img.classList.add('opacity-0', 'scale-95');
        spinner.classList.remove('hidden');
        img.src = src;
        img.alt = alt || '';
        // If the browser already has this image cached, `load` may have
        // fired before the listener below was attached — check first.
        if (img.complete) showImage();

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        // Force a reflow so the browser registers the "hidden" -> visible
        // state change before we animate opacity, otherwise the transition
        // is skipped and the modal just pops in.
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
    };

    const close = () => {
        modal.classList.add('opacity-0');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            modal.classList.add('hidden');
            img.src = '';
        }, TRANSITION_MS);
    };

    img.addEventListener('load', showImage);

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-lightbox-trigger]');
        if (trigger) {
            open(trigger.dataset.lightboxSrc, trigger.dataset.lightboxAlt);
            return;
        }
        if (event.target.closest('[data-lightbox-close]') || event.target === img || event.target === modal) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            close();
        }
    });
});

// Back-to-top button — shows once the page has scrolled past one viewport.
document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('back-to-top');
    if (!button) return;

    const toggle = () => {
        button.classList.toggle('hidden', window.scrollY < window.innerHeight);
    };

    toggle();
    window.addEventListener('scroll', toggle, { passive: true });
    button.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
});
