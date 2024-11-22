// Get elements
const slider = document.getElementById('slider');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

// Initialize the index of the current image
let currentIndex = 0;

// Function to move to the next slide
function nextSlide() {
    if (currentIndex === slider.children.length - 1) {
        currentIndex = 0;
    } else {
        currentIndex++;
    }
    updateSlider();
}

// Function to move to the previous slide
function prevSlide() {
    if (currentIndex === 0) {
        currentIndex = slider.children.length - 1;
    } else {
        currentIndex--;
    }
    updateSlider();
}

// Function to update the slider's transform property to slide to the correct image
function updateSlider() {
    const width = slider.clientWidth;
    slider.style.transform = `translateX(-${currentIndex * width}px)`;
}

// Event listeners for the buttons
nextButton.addEventListener('click', nextSlide);
prevButton.addEventListener('click', prevSlide);

// Auto-slide functionality every 5 seconds
setInterval(nextSlide, 5000);

// Initial update
updateSlider();
