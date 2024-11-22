<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'user_system';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Placeholder for user session
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Replace this with your authentication logic
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uc_package = $_POST['uc_package'];
    $price = 0;
    $payment_method = $_POST['payment_method'];

    // Validate UC package and set price
    $uc_prices = [
        '60' => 0.99,
        '325' => 4.99,
        '660' => 9.99,
        '1800' => 24.99,
    ];

    if (!array_key_exists($uc_package, $uc_prices)) {
        die("Invalid UC package selected.");
    }

    $price = $uc_prices[$uc_package];
    $order_id = uniqid('ORD-');
    $transaction_id = uniqid('TRANS-');

    try {
        // Insert into the orders table
        $orderQuery = "INSERT INTO orders (user_id, uc_amount, price, payment_method, payment_status, order_date) 
                       VALUES (:user_id, :uc_amount, :price, :payment_method, 'pending', NOW())";
        $orderStmt = $pdo->prepare($orderQuery);
        $orderStmt->execute([
            ':user_id' => $user_id,
            ':uc_amount' => $uc_package,
            ':price' => $price,
            ':payment_method' => $payment_method,
        ]);

        // Get the order ID of the inserted record
        $orderId = $pdo->lastInsertId();

        // Insert into the payments table
        $paymentQuery = "INSERT INTO payments (order_id, transaction_id, amount, payment_status, payment_date) 
                         VALUES (:order_id, :transaction_id, :amount, 'completed', NOW())";
        $paymentStmt = $pdo->prepare($paymentQuery);
        $paymentStmt->execute([
            ':order_id' => $orderId,
            ':transaction_id' => $transaction_id,
            ':amount' => $price,
        ]);

        // Redirect to receipt page
        header("Location: topup.php?receipt=true&order_id=$orderId");
        exit;
    } catch (Exception $e) {
        die("An error occurred while processing your request. Please try again later.");
    }
}

// Handle receipt display
if (isset($_GET['receipt']) && isset($_GET['order_id'])) {
    $order_id = htmlspecialchars($_GET['order_id']);

    // Fetch receipt details
    $receiptQuery = "SELECT o.id AS order_id, o.uc_amount, o.price, o.payment_method, o.payment_status, o.order_date, 
                            p.transaction_id, p.payment_status AS transaction_status, p.payment_date 
                     FROM orders o
                     INNER JOIN payments p ON o.id = p.order_id
                     WHERE o.id = :order_id";
    $receiptStmt = $pdo->prepare($receiptQuery);
    $receiptStmt->execute([':order_id' => $order_id]);
    $receipt = $receiptStmt->fetch(PDO::FETCH_ASSOC);

    if ($receipt) {
        echo "
        <div class='receipt-container'>
            <h1>Payment Receipt</h1>
            <div class='receipt-details'>
                <p><span>Order ID:</span> {$receipt['order_id']}</p>
                <p><span>UC Amount:</span> {$receipt['uc_amount']} UC</p>
                <p><span>Price:</span> \${$receipt['price']}</p>
                <p><span>Payment Method:</span> {$receipt['payment_method']}</p>
                <p><span>Order Date:</span> {$receipt['order_date']}</p>
                <p><span>Transaction ID:</span> {$receipt['transaction_id']}</p>
                <p><span>Payment Status:</span> {$receipt['transaction_status']}</p>
                <p><span>Payment Date:</span> {$receipt['payment_date']}</p>
            </div>
            <a class='back-link' href='topup.php'>Back to Top-Up</a>
        </div>";
        exit;
    }
     else {
        echo "<p>No receipt found for this order.</p>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBG UC Top-Up</title>
    <link rel="stylesheet" href="topup.css">
    <script>
        // Dynamically update price based on selected UC package
        function updatePrice() {
            const ucPrices = {
                '60': 0.99,
                '325': 4.99,
                '660': 9.99,
                '1800': 24.99
            };
            const ucPackage = document.getElementById('uc_package').value;
            const priceInput = document.getElementById('price');
            priceInput.value = ucPrices[ucPackage];
        }
    </script>
</head>
<body>
    <h1>PUBG UC Top-Up</h1>
    <form method="POST" action="">
        <label for="uc_package">Select UC Package:</label><br>
        <select id="uc_package" name="uc_package" onchange="updatePrice()" required>
            <option value="60">60 UC - $0.99</option>
            <option value="325">325 UC - $4.99</option>
            <option value="660">660 UC - $9.99</option>
            <option value="1800">1800 UC - $24.99</option>
        </select><br><br>

        <label for="price">Price (USD):</label><br>
        <input type="number" id="price" name="price" step="0.01" readonly required><br><br>

        <label for="payment_method">Payment Method:</label><br>
        <select id="payment_method" name="payment_method" required>
            <option value="PayPal">PayPal</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select><br><br>

        <button type="submit">Submit</button>
    </form>
        <!-- Add a return button -->
        <a class="return-button" href="index.php">Return to Home</a>
</body>
</html>

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: url('images/topup.jpg') no-repeat center center fixed; /* Replace 'background.jpg' with your desired background image */
    background-size: cover;
    color: #fff;
    text-align: center;
}

/* Page Header */
h1 {
    margin-top: 20px;
    font-size: 2.5em;
    color: #ffd700; /* Golden color for emphasis */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

/* Form Container */
form {
    background: rgba(0, 0, 0, 0.8);
    padding: 20px;
    margin: 20px auto;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
}

label {
    font-size: 1.2em;
    color: #ffd700;
}

select, input, button {
    width: 100%;
    margin-top: 10px;
    margin-bottom: 20px;
    padding: 10px;
    font-size: 1em;
    border-radius: 5px;
    border: none;
}

select, input {
    background: rgba(255, 255, 255, 0.8);
    color: #000;
}

button {
    background: #ffd700;
    color: #000;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
}

button:hover {
    background: #ffa500;
}
/* Receipt Container */
.receipt-container {
    margin: 50px auto;
    padding: 30px;
    max-width: 600px;
    background: linear-gradient(135deg, #fff, #f9f9f9);
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    font-family: 'Arial', sans-serif;
}

/* Receipt Header */
.receipt-container h1 {
    text-align: center;
    font-size: 24px;
    color: #333;
    border-bottom: 2px solid #ffd700;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

/* Receipt Details */
.receipt-details p {
    font-size: 16px;
    line-height: 1.6;
    margin: 8px 0;
    color: #444;
}

.receipt-details p span {
    font-weight: bold;
    color: #222;
}

/* Back Link */
.back-link {
    display: block;
    width: fit-content;
    margin: 20px auto 0;
    padding: 10px 20px;
    text-decoration: none;
    color: #fff;
    background-color: #333;
    border-radius: 5px;
    font-weight: bold;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease-in-out;
}

.back-link:hover {
    background-color: #555;
}

/* Return Button */
.return-button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #0078d7;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease-in-out;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
}

.return-button:hover {
    background-color: #0053a6;
}



</style>