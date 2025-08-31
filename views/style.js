const track = document.querySelector('.carousel-track');
const slides = Array.from(track.children);
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let currentIndex = 0;

function updateSlide() {
  const width = slides[0].getBoundingClientRect().width;
  track.style.transform = `translateX(-${currentIndex * width}px)`;
}

nextButton.addEventListener('click', () => {
  currentIndex = (currentIndex + 1) % slides.length;
  updateSlide();
});

prevButton.addEventListener('click', () => {
  currentIndex = (currentIndex - 1 + slides.length) % slides.length;
  updateSlide();
});
