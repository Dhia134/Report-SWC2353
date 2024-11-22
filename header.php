<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="header.php">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <img src="images/logodd.jpg" alt="PUBG Mobile Logo">
            </a>
            
            <!-- Navigation Buttons -->
            <nav class="nav-buttons">
                <a href="https://pubg.com/en/news" class="nav-btn">News</a>
                <a href="https://support.pubgmobile.com/" class="nav-btn">Support</a>
                <a href="https://www.pubg.com/en/clause/term_of_service/label_steam/latest" class="nav-btn">Terms of Services</a>
            </nav>

            <!-- Cart Icon -->
            <a href="topup.php" class="cart">
                <img src="images/cart.png" alt="Cart">
            <a href="logout.php" class="logout">
                <img src="images/logouticon.jpg" alt="logout">
            </a>
        </div>
    </header>
</body>
</html>

<style>
/* General Styling */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* Main Header */
.main-header {
    width: 100%;
    height: 60px;
    background-color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    z-index: 1000;
}

.container {
    width: 90%;
    max-width: 1200px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Logo Styling */
.logo img {
    height: 60px;
    display: block;
}

/* Navigation Buttons */
.nav-buttons {
    display: flex;
    gap: 20px;
}

.nav-btn {
    color: white;
    text-decoration: none;
    font-size: 16px;
    padding: 10px;
    transition: background-color 0.3s;
}

.nav-btn:hover {
    background-color: #333;
}

/* Cart Icon Styling */
.cart img {
    height: 30px;
    display: block;
    cursor: pointer;
}
/* logout Icon Styling */
.logout img {
    height: 30px;
    display: block;
    cursor: pointer;
}
/* Responsive Design */
@media (max-width: 768px) {
    .logo img {
        height: 30px;
    }
    .cart img {
        height: 25px;
    }

    .nav-buttons {
        gap: 10px;
    }

    .nav-btn {
        font-size: 14px;
        padding: 8px;
    }
}

</style>
