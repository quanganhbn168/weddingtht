import './bootstrap';
import AOS from 'aos';
import GLightbox from 'glightbox';

// Init AOS on DOM ready
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
        duration: 800,
        once: true,
        offset: 60,
        easing: 'ease-out-cubic',
    });

    // Init GLightbox
    if (document.querySelector('.glightbox')) {
        GLightbox({ selector: '.glightbox' });
    }
});
