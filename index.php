<?php
// Include the database connection
include('db_connection.php');
// Redirect to login page if not logged in
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ddGame - Popular Game Top-Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>

<body>
<section class="carousel-section">
    <div class="carousel">
        <!-- Carousel Images -->
        <div class="carousel-slide" style="background-image: url('images/ban1.jpg');"></div>
        <div class="carousel-slide" style="background-image: url('images/BG\ 3.jpg');"></div>
        <div class="carousel-slide" style="background-image: url('images/cr3.jpg');"></div>
        <div class="carousel-slide" style="background-image: url('images/bg\ 2.jpg');"></div>

        <!-- Overlay Buttons -->
        <div class="carousel-overlay">
            <a href="https://www.apple.com/app-store/" class="download-button app-store" target="_blank">
                <div class="button-content">
                    <img src="images/app store.jpg" alt="App Store">
                    <span>
                        <h3>Download on the App Store</h3>
                    </span>
                </div>
            </a>
            <a href="path_to_your_apk_file.apk" class="download-button apk-download" target="_blank">
                <div class="button-content">
                    <img src="images/apk.png" alt="APK Download">
                    <span>
                        <h3>APK download 1.0 GB</h3>
                    </span>
                </div>
            </a>
        </div>

        <!-- Headline Section -->
        <div class="carousel-headline">
            <h2>DDGAME</h2>
            <p>PUBG MOBILE</p>
        </div>
    </div>

    <!-- Mini Carousel -->
    <div class="mini-carousel">
        <div class="mini-slide" style="background-image: url('images/ban1.jpg');"></div>
        <div class="mini-slide" style="background-image: url('images/BG\ 3.jpg');"></div>
        <div class="mini-slide" style="background-image: url('images/cr3.jpg');"></div>
        <div class="mini-slide" style="background-image: url('images/bg\ 2.jpg');"></div>
    </div>
</section>

<!-- Section 1 -->
<section id="section1" class="landing-page landing-page1" data-aos="fade-up">
    <div class="content">
        <h1>ABOUT GAME</h1>
        <p>PUBG MOBILE!</p>
        <a href="game.php" class="enter-button">ENTER</a>
    </div>
</section>

<!-- Section 2 -->
<section id="section2" class="landing-page landing-page2" data-aos="fade-up">
    <div class="content">
        <h1>ROYAL PASS</h1>
        <p>Get the Royal Pass and dominate the game!</p>
        <a href="royale_pass.php" class="enter-button">ENTER</a>
</section>

<!-- Section 3 -->
<section id="section3" class="landing-page landing-page3" data-aos="fade-up">
    <div class="content">
        <h1>WEAPONS</h1>
        <p>Explore a wide array of weapons!</p>
        <a href="weapons.php" class="enter-button">ENTER</a>
    </div>
</section>

<!-- AOS Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 1200, // Animation duration
        once: true, // Run animation only once
    });
</script>

<?php
// Close the database connection
$conn->close();
?>



<footer>
    <?php include 'footer.php'; ?>
    <a href="logout.php" class= "logout-button" >Logout</button>
</footer>

</body>
</html>