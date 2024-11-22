document.addEventListener("DOMContentLoaded", () => {
    // Form Focus Scaling Effect
    const form = document.querySelector(".form-container form");
    const inputs = document.querySelectorAll("input");

    if (form && inputs) {
        inputs.forEach(input => {
            input.addEventListener("focus", () => {
                form.style.transform = "scale(1.02)";
            });

            input.addEventListener("blur", () => {
                form.style.transform = "scale(1)";
            });
        });
    }

    // Particle Effect
    const particles = [];
    const maxParticles = 200; // Limit the number of particles for better performance
    const particleCanvas = document.createElement("canvas");
    particleCanvas.style.position = "absolute";
    particleCanvas.style.top = "0";
    particleCanvas.style.left = "0";
    particleCanvas.width = window.innerWidth;
    particleCanvas.height = window.innerHeight;
    document.body.appendChild(particleCanvas);

    const ctx = particleCanvas.getContext("2d");

    function createParticle(x, y) {
        if (particles.length < maxParticles) {
            particles.push({
                x: x,
                y: y,
                size: Math.random() * 5 + 1,
                speedX: (Math.random() - 0.5) * 2,
                speedY: (Math.random() - 0.5) * 2,
                color: `rgba(${Math.random() * 255}, ${Math.random() * 255}, 255, 0.8)`
            });
        }
    }

    function updateParticles() {
        ctx.clearRect(0, 0, particleCanvas.width, particleCanvas.height);

        particles.forEach((particle, index) => {
            particle.x += particle.speedX;
            particle.y += particle.speedY;

            ctx.fillStyle = particle.color;
            ctx.beginPath();
            ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            ctx.fill();

            if (particle.size > 0.1) {
                particle.size -= 0.05;
            } else {
                particles.splice(index, 1);
            }
        });

        requestAnimationFrame(updateParticles);
    }

    window.addEventListener("mousemove", (e) => {
        createParticle(e.clientX, e.clientY);
    });

    updateParticles();
});

document.addEventListener("DOMContentLoaded", () => {
    // Audio Player Controls
    const audio = document.getElementById("background-audio");
    const playPauseButton = document.getElementById("play-pause-button");
    const volumeSlider = document.getElementById("volume-slider");

    // Check if elements exist to avoid errors
    if (audio && playPauseButton && volumeSlider) {
        // Ensure autoplay works (modern browsers may require interaction)
        if (audio.autoplay) {
            audio.play().catch(error => {
                console.log('Autoplay prevented. User interaction required.', error);
            });
        }

        // Play/Pause Button Functionality
        playPauseButton.addEventListener("click", () => {
            if (audio.paused) {
                audio.play();
                playPauseButton.textContent = "Pause"; // Update button text
            } else {
                audio.pause();
                playPauseButton.textContent = "Play"; // Update button text
            }
        });

        // Volume Slider Functionality
        volumeSlider.addEventListener("input", (event) => {
            audio.volume = event.target.value;
        });

        // Initialize Volume Slider
        volumeSlider.value = audio.volume; // Set slider to current volume
    } else {
        console.error("Audio player elements not found in the DOM.");
    }
});
