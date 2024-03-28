document.addEventListener('DOMContentLoaded', () => {
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

document.querySelector('.left-arrow').addEventListener('click', () => {
    slides[currentSlide].style.display = 'none';
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    slides[currentSlide].style.display = 'block';
});

document.querySelector('.right-arrow').addEventListener('click', () => {
    slides[currentSlide].style.display = 'none';
    currentSlide = (currentSlide + 1) % totalSlides;
    slides[currentSlide].style.display = 'block';
});
});
