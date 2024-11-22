<?php
// Database configuration
$host = 'localhost'; // Database host
$dbname = 'user_system'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$error = '';
$success = '';

// Check if the sign-up form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $user_password = trim($_POST['password']);
    $role = 'user'; // Default role is 'user'

    // Check if the email already exists
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error = "Email already in use.";
    } else {
        // Hash the password before saving to the database
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $query = "INSERT INTO users (email, password, role, created_at) VALUES (:email, :password, :role, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $success = "Registration successful! You can now log in.";
        } else {
            $error = "An error occurred during registration.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>

    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p style='color: green;'>$success</p>"; } ?>

    <form action="signup.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Sign Up">
    </form>

    <br>
    <a href="login.php"><button>Already have an account? Login</button></a>

</body>
</html>

<style>
/* General body styling */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: url('images/login2.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
}

/* Glassmorphism container */
form {
    background: rgba(255, 255, 255, 0.1); /* Transparent white for glass effect */
    border-radius: 12px;
    backdrop-filter: blur(10px); /* Blur effect */
    -webkit-backdrop-filter: blur(10px); /* For Safari */
    width: 400px;
    padding: 30px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
    text-align: center;
}

/* Form header */
h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #fff;
}

/* Input fields styling */
form label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: #fff;
    text-align: left;
}

form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    outline: none;
    transition: border-color 0.3s ease;
}

/* Input focus styling */
form input[type="email"]:focus,
form input[type="password"]:focus {
    border-color: #ff6b81; /* Highlight color */
    outline: none;
    box-shadow: 0 0 4px #ff6b81;
}

/* Submit button styling */
form input[type="submit"] {
    background-color: #f4b400; /* Bright yellow color */
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
    margin-top: 10px;
}

form input[type="submit"]:hover {
    background-color: #d99400;
}

/* Link button styling */
form a button {
    background-color: transparent;
    color: #f4b400;
    font-size: 14px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    text-decoration: underline;
}

form a button:hover {
    text-decoration: none;
}

/* Error and success messages */
p {
    font-size: 14px;
    margin-top: 10px;
}

p[style*="color: red"] {
    color: #ff4d4d; /* Error message color */
}

p[style*="color: green"] {
    color: #4caf50; /* Success message color */
}

</style>