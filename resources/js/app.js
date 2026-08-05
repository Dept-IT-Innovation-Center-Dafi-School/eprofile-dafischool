// Admin toast notifications — a global Alpine store fed either by a Livewire
// `$this->dispatch('toast', ...)` browser event, or (for actions that redirect,
// where no live component remains to dispatch from) an inline bootstrap script
// reading the flashed session message on page load. Registered on 'alpine:init'
// since Alpine itself is injected by Livewire, not bundled here.

// Quill CSS - import at top level so it's always available
import 'quill/dist/quill.snow.css';

let toastId = 0;

document.addEventListener('alpine:init', () => {
    Alpine.data('richTextEditor', () => ({
        editor: null,
        async init() {
            const { default: Quill } = await import('quill');

            const textarea = document.getElementById('program');
            this.editor = new Quill(this.$refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link'],
                        ['clean'],
                    ],
                },
            });

            // Load initial content: set editor DOM directly, then sync to textarea
            if (textarea.value) {
                this.editor.root.innerHTML = textarea.value;
            }

            // Sync editor content to textarea on any change
            this.editor.on('text-change', () => {
                textarea.value = this.editor.root.innerHTML;
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
            });

            // Also sync on form submit to ensure latest content
            const form = this.editor.root.closest('form');
            if (form) {
                form.addEventListener('submit', () => {
                    textarea.value = this.editor.root.innerHTML;
                });
            }
        },
    }));

    Alpine.store('toast', {
        items: [],
        push(type, message) {
            const id = ++toastId;
            this.items.push({ id, type, message });
            setTimeout(() => this.dismiss(id), 5000);
        },
        dismiss(id) {
            this.items = this.items.filter((item) => item.id !== id);
        },
    });

    Alpine.store('confirm', {
        open: false,
        title: '',
        message: '',
        confirmLabel: 'Hapus',
        variant: 'danger',
        confirmText: null,
        typed: '',
        loading: false,
        onConfirm: null,
        show({ title = '', message, confirmLabel = 'Hapus', variant = 'danger', confirmText = null, onConfirm }) {
            this.title = title;
            this.message = message;
            this.confirmLabel = confirmLabel;
            this.variant = variant;
            this.confirmText = confirmText;
            this.typed = '';
            this.loading = false;
            this.onConfirm = onConfirm;
            this.open = true;
        },
        get canConfirm() {
            return !this.loading && (this.confirmText === null || this.typed === this.confirmText);
        },
        async confirm() {
            if (!this.canConfirm || !this.onConfirm) return;
            this.loading = true;
            try {
                await this.onConfirm();
            } finally {
                this.loading = false;
            }
            this.close();
        },
        close() {
            if (this.loading) return;
            this.open = false;
            this.onConfirm = null;
        },
    });
});

// Initialize hero swiper if element exists — Swiper is loaded on demand so
// pages without a carousel (all of the admin panel, the login screen) don't
// pay for its ~80KB JS + CSS on every load.
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.hero-swiper')) {
        import('./hero-swiper.js');
    }
    if (document.querySelector('.testimonial-swiper')) {
        import('./testimonial-swiper.js');
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
