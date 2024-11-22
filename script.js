document.addEventListener('DOMContentLoaded', function() {
    const buyButtons = document.querySelectorAll('.buy-button');
    
    buyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const packageId = this.getAttribute('data-id');
            // Trigger an AJAX call to process the top-up
            purchasePackage(packageId);
        });
    });
});

function purchasePackage(packageId) {
    fetch('process_purchase.php', {
        method: 'POST',
        body: JSON.stringify({ packageId: packageId }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Purchase successful! Your receipt is printed.');
            printReceipt(data.receipt);
        } else {
            alert('There was an error with your purchase.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

function printReceipt(receipt) {
    const receiptWindow = window.open('', '_blank');
    receiptWindow.document.write('<h1>Receipt</h1>');
    receiptWindow.document.write('<p>' + receipt + '</p>');
    receiptWindow.document.close();
    receiptWindow.print();
}

// login.js
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".form-container form");
    const inputs = document.querySelectorAll("input");

    inputs.forEach(input => {
        input.addEventListener("focus", () => {
            form.style.transform = "scale(1.02)";
        });

        input.addEventListener("blur", () => {
            form.style.transform = "scale(1)";
        });
    });

    // Add a particle effect (optional)
    let particles = [];
    const particleCanvas = document.createElement("canvas");
    particleCanvas.style.position = "absolute";
    particleCanvas.style.top = "0";
    particleCanvas.style.left = "0";
    particleCanvas.width = window.innerWidth;
    particleCanvas.height = window.innerHeight;
    document.body.appendChild(particleCanvas);

    const ctx = particleCanvas.getContext("2d");

    function createParticle(x, y) {
        particles.push({
            x: x,
            y: y,
            size: Math.random() * 5 + 1,
            speedX: (Math.random() - 0.5) * 2,
            speedY: (Math.random() - 0.5) * 2,
            color: `rgba(${Math.random() * 255}, ${Math.random() * 255}, 255, 0.8)`
        });
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


// login.js
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".form-container form");
    const inputs = document.querySelectorAll("input");

    inputs.forEach(input => {
        input.addEventListener("focus", () => {
            form.style.transform = "scale(1.02)";
        });

        input.addEventListener("blur", () => {
            form.style.transform = "scale(1)";
        });
    });

    // Add a particle effect (optional)
    let particles = [];
    const particleCanvas = document.createElement("canvas");
    particleCanvas.style.position = "absolute";
    particleCanvas.style.top = "0";
    particleCanvas.style.left = "0";
    particleCanvas.width = window.innerWidth;
    particleCanvas.height = window.innerHeight;
    document.body.appendChild(particleCanvas);

    const ctx = particleCanvas.getContext("2d");

    function createParticle(x, y) {
        particles.push({
            x: x,
            y: y,
            size: Math.random() * 5 + 1,
            speedX: (Math.random() - 0.5) * 2,
            speedY: (Math.random() - 0.5) * 2,
            color: `rgba(${Math.random() * 255}, ${Math.random() * 255}, 255, 0.8)`
        });
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
