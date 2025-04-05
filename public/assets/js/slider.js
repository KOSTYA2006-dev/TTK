document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    const dots = document.querySelectorAll('.dot');

    let currentSlide = 0;
    const slideCount = slides.length;
    let autoSlideInterval;

    // Инициализация слайдера
    function initSlider() {
        updateSlider();
        startAutoSlide();
    }

    // Обновление позиции слайдера
    function updateSlider() {
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;

        // Обновление активной точки
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }

    // Переключение на следующий слайд
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slideCount;
        updateSlider();
    }

    // Переключение на предыдущий слайд
    function prevSlide() {
        currentSlide = (currentSlide - 1 + slideCount) % slideCount;
        updateSlider();
    }

    // Автоматическое перелистывание
    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 5000);
    }

    // Остановка автоматического перелистывания
    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    // Обработчики событий
    nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoSlide();
        startAutoSlide();
    });

    prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoSlide();
        startAutoSlide();
    });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateSlider();
            stopAutoSlide();
            startAutoSlide();
        });
    });

    // Пауза при наведении
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);

    // Запуск слайдера
    initSlider();
});
