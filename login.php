<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'user_system';
$username = 'root';
$password = '';

// Create a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the login form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $user_password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($user_password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on user role
            header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'index.php'));
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
<div class="audio-player">
    <audio id="background-audio" src="audio/your-audio-file.mp3" autoplay loop></audio>
    <button id="play-pause-button">Pause</button>
    <input type="range" id="volume-slider" min="0" max="1" step="0.1" value="0.5">
</div>

    <!-- Animated Background -->
    <div class="animated-background"></div>

    <!-- Left Image -->
    <div class="side-image left-image">
        <img src="images/sss-unscreen.gif" alt="Left Image">
    </div>


    <!-- Login Form -->
    <div class="form-container">
        <form action="login.php" method="POST">
            <h2 class="animated-text">Welcome Back!</h2>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="submit" value="LOGIN">
            <div class="extra-links">
                <a href="signup.php">Sign Up</a>
            </div>
        </form>
    </div>

    <!-- Flight Image -->
    <img src="images/bullet-unscreen.gif" alt="Flight" class="flight" id="flight">

    <!-- Explosion Image -->
    <div class="explosion" id="explosion"></div>

    <!-- Audio Player -->
    <div class="audio-player">
        <audio id="background-audio" src="images/audio.mp3" autoplay loop></audio>
        <button id="play-pause-button">Pause</button>
        <input type="range" id="volume-slider" min="0" max="1" step="0.1" value="0.5">
    </div>

    <script src="login.js"></script>
</body>
</html>
