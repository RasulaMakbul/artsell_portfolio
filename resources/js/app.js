import './bootstrap';
import Alpine from 'alpinejs';
import AOS, { init } from 'aos';
import 'aos/dist/aos.css';

import Swiper from 'swiper';
import 'swiper/swiper-bundle.css';



// AOS.init();
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
        offset: 200,
        duration: 1000,
        easing: 'ease-in-out',
        once: true
    });
});

// Initialize Swiper
document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper-container', {
        // Swiper options here
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});




window.Alpine = Alpine;

Alpine.start();


