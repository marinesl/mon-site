// public/js/comments-slider.js
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('#comments .comments-slider');
    if (!slider) {
        return;
    }

    const track = slider.querySelector('.comments-slides');
    if (!track) {
        return;
    }

    const slides = Array.prototype.slice.call(
        track.querySelectorAll('li')
    );
    const dots = Array.prototype.slice.call(
        slider.querySelectorAll('.comments-dots button')
    );
    const prevBtn = slider.querySelector('.comments-prev');
    const nextBtn = slider.querySelector('.comments-next');

    if (!slides.length) {
        return;
    }

    const groupSize = 2; // number of comments per "slide"
    const groupCount = Math.ceil(slides.length / groupSize);

    let current = 0; // current group index
    const autoplay = slider.getAttribute('data-autoplay') === 'true';
    const interval = parseInt(slider.getAttribute('data-interval'), 10) || 7000;
    let timer = null;

    function updateDots() {
        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === current);
        });
    }

    function showSlide(index) {
        if (!groupCount) {
            return;
        }

        current = (index + groupCount) % groupCount;

        // translateX(%) is relative to the track's own width, which equals
        // one visible "page" (groupSize slides at 100/groupSize% each).
        const offsetPercent = -100 * current;
        track.style.transform = 'translateX(' + offsetPercent + '%)';

        updateDots();
    }

    function next() {
        showSlide(current + 1);
    }

    function prev() {
        showSlide(current - 1);
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            next();
            restartAutoplay();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            prev();
            restartAutoplay();
        });
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            const target = parseInt(dot.getAttribute('data-slide'), 10) || 0;
            showSlide(target);
            restartAutoplay();
        });
    });

    function startAutoplay() {
        if (!autoplay || groupCount <= 1) {
            return;
        }
        stopAutoplay();
        timer = window.setInterval(next, interval);
    }

    function stopAutoplay() {
        if (timer !== null) {
            window.clearInterval(timer);
            timer = null;
        }
    }

    function restartAutoplay() {
        stopAutoplay();
        startAutoplay();
    }

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);

    // Init
    track.style.transform = 'translateX(0%)';
    showSlide(0);
    startAutoplay();
});