/**
 * Wedding Invitation Frontend Bundle
 * - AOS (scroll animations)
 * - Swiper (gallery/guestbook sliders)
 * - GLightbox (photo lightbox)
 * - Alpine.js countdown helper
 */

import AOS from 'aos';
import Swiper from 'swiper/bundle';
import GLightbox from 'glightbox';

// Expose to global scope for inline usage in templates
window.Swiper = Swiper;
window.GLightbox = GLightbox;

// Initialize AOS
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 1000,
        once: true,
        offset: 50,
    });
});

// Alpine.js countdown component
document.addEventListener('alpine:init', () => {
    Alpine.data('countdown', (targetDate) => ({
        days: '00',
        hours: '00',
        minutes: '00',
        seconds: '00',
        interval: null,

        init() {
            this.updateCountdown();
            this.interval = setInterval(() => this.updateCountdown(), 1000);
        },

        destroy() {
            if (this.interval) clearInterval(this.interval);
        },

        updateCountdown() {
            const target = new Date(targetDate).getTime();
            const now = new Date().getTime();
            const diff = target - now;

            if (diff <= 0) {
                this.days = '00';
                this.hours = '00';
                this.minutes = '00';
                this.seconds = '00';
                if (this.interval) clearInterval(this.interval);
                return;
            }

            this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
            this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
        },
    }));

    // RSVP form component
    Alpine.data('rsvpForm', (submitUrl) => ({
        submitting: false,
        success: false,
        error: null,
        formData: {
            name: '',
            phone: '',
            attendance: 'yes',
            guests: '1',
            side: 'both',
            note: '',
        },

        async submitRsvp() {
            this.submitting = true;
            this.error = null;
            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.formData),
                });
                if (response.ok) {
                    this.success = true;
                } else {
                    const data = await response.json();
                    this.error = data.message || 'Có lỗi xảy ra.';
                }
            } catch (e) {
                this.error = 'Lỗi kết nối. Vui lòng thử lại.';
            } finally {
                this.submitting = false;
            }
        },
    }));

    // Wish form component
    Alpine.data('wishForm', (submitUrl) => ({
        open: false,
        submitting: false,
        success: false,
        error: null,
        formData: { name: '', message: '' },

        async submitWish() {
            this.submitting = true;
            this.error = null;
            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.formData),
                });
                if (response.ok) {
                    this.success = true;
                    this.formData = { name: '', message: '' };
                    setTimeout(() => {
                        this.success = false;
                        this.open = false;
                    }, 3000);
                } else {
                    const data = await response.json();
                    this.error = data.message || 'Có lỗi xảy ra.';
                }
            } catch (e) {
                this.error = 'Lỗi kết nối.';
            } finally {
                this.submitting = false;
            }
        },
    }));
});

// Auto-init Swiper instances on elements with data-swiper attribute
document.addEventListener('DOMContentLoaded', () => {
    // Gallery slider
    document.querySelectorAll('.wedding-gallery-slider').forEach((el) => {
        new Swiper(el, {
            spaceBetween: 10,
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
            autoplay: { delay: 3000, disableOnInteraction: false },
        });
    });

    // Guestbook slider
    document.querySelectorAll('.wedding-guestbook-slider').forEach((el) => {
        new Swiper(el, {
            spaceBetween: 20,
            autoplay: { delay: 4000 },
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
        });
    });

    // GLightbox for galleries
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
    });
});
