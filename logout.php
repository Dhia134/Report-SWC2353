<?php
// Start session
session_start();

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Destroy session
    session_unset();
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="logout.css"> <!-- Link to your CSS -->
</head>
<body>
     <!-- Background Music -->
     <audio id="bg-music" muted loop>
        <source src="/images/Alan_Walker_-_On_My_Way__PUBG_Music_Video__[_YouConvert.net_].mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

<div class="logout-container">
    <!-- Title -->
    <h1 class="title-text">THANKYOU RANGERS</h1>
    
    <!-- Logout Form -->
    <form method="POST">
        <button type="submit" name="logout" class="logout-button">
            Logout
        </button>
    </form>

      <!-- Right Image -->
      <div class="side-image right-image">
        <img src="images/celebrate-unscreen.gif" alt="Right Image">
    </div>

    <!-- Back to Homepage Button -->
    <a href="index.php" class="back-homepage-button">Back to Homepage</a>
</div>
</body>
</html>

<style>
/* Container for the logout button and title */
.logout-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: url('images/login.jpg') no-repeat center center fixed; /* Use your background image */
    background-size: cover;
    position: relative;
}

/* Styling for the title text */
.title-text {
    font-size: 50px; /* Big text size */
    color: #ffffff; /* White text color */
    font-weight: bold; /* Bold font weight */
    text-transform: uppercase; /* Make all letters uppercase */
    margin-bottom: 20px; /* Space between title and button */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Subtle text shadow for contrast */
    text-align: center; /* Center-align the title */
    font-family: 'Arial', sans-serif; /* Font style */
}

/* Logout button styling */
.logout-button {
    background: linear-gradient(135deg, #ff416c, #ff4b2b); /* Stylish gradient */
    color: #fff;
    padding: 15px 30px;
    font-size: 18px;
    font-weight: bold;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Drop shadow */
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

/* Hover effect with glow */
.logout-button:hover {
    background: linear-gradient(135deg, #ff4b2b, #ff416c); /* Reverse gradient on hover */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 6px 20px rgba(255, 75, 43, 0.5); /* Glow effect */
}

/* Focus effect */
.logout-button:focus {
    outline: none;
    box-shadow: 0 0 10px rgba(255, 75, 43, 0.7);
}

/* Back to Homepage Button */
.back-homepage-button {
    position: absolute;
    bottom: 30px; /* Position from the bottom */
    left: 30px; /* Position from the left */
    background: linear-gradient(135deg, #4b79a1, #283e51); /* Blue gradient */
    color: #fff;
    padding: 12px 25px;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    border-radius: 30px;
    text-decoration: none; /* Remove underline */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Drop shadow */
    transition: all 0.3s ease;
}

/* Hover effect for Back to Homepage */
.back-homepage-button:hover {
    background: linear-gradient(135deg, #283e51, #4b79a1); /* Reverse gradient on hover */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 6px 20px rgba(43, 121, 161, 0.5); /* Glow effect */
}

/* Button inner glow effect */
.logout-button:after,
.back-homepage-button:after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.2);
    z-index: -1;
    opacity: 0;
    border-radius: 30px;
    transition: opacity 0.3s ease;
}

.logout-button:hover:after,
.back-homepage-button:hover:after {
    opacity: 1;
}
</style>
