<?php
// Start session
session_start();

// Include the database connection
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input values
    $player_id = $_POST['player_id'];          // Player ID entered by the user
    $uc_package = $_POST['uc_package'];        // Selected UC Package (e.g., 100 UC)
    $payment_methods = isset($_POST['payment-method']) ? $_POST['payment-method'] : [];
    
    // Check if player ID, UC package, and payment method are provided
    if (!empty($player_id) && !empty($uc_package) && !empty($payment_methods)) {
        // Extract UC and price from the selected package (format: 100, 1.99)
        list($uc_amount, $price) = explode(',', $uc_package);
        
        // Prepare SQL to insert a new order
        $stmt = $conn->prepare("INSERT INTO orders (user_id, uc_amount, price, payment_method, payment_status) VALUES (?, ?, ?, ?, 'pending')");
        if ($stmt === false) {
            // Error in preparing statement
            die('MySQL error: ' . $conn->error);
        }
        
        // Bind parameters and execute
        $stmt->bind_param("iids", $_SESSION['user_id'], $uc_amount, $price, implode(',', $payment_methods));
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Get the last inserted order ID
            $order_id = $stmt->insert_id;

            // Insert a payment record (simulated payment)
            $transaction_id = "TXN" . rand(1000, 9999); // Simulated transaction ID
            $stmt_payment = $conn->prepare("INSERT INTO payments (order_id, transaction_id, amount, payment_status) VALUES (?, ?, ?, 'success')");
            if ($stmt_payment === false) {
                // Error in preparing payment statement
                die('MySQL error: ' . $conn->error);
            }

            // Bind parameters and execute
            $stmt_payment->bind_param("isds", $order_id, $transaction_id, $price, $payment_status = 'success');
            $stmt_payment->execute();

            if ($stmt_payment->affected_rows > 0) {
                // Insert tracking record for this order
                $stmt_tracking = $conn->prepare("INSERT INTO order_tracking (order_id, status) VALUES (?, 'created')");
                if ($stmt_tracking === false) {
                    // Error in preparing tracking statement
                    die('MySQL error: ' . $conn->error);
                }

                // Bind parameters and execute
                $stmt_tracking->bind_param("i", $order_id);
                $stmt_tracking->execute();

                // Update order status to 'completed'
                $stmt_update_order = $conn->prepare("UPDATE orders SET payment_status = 'completed' WHERE id = ?");
                if ($stmt_update_order === false) {
                    // Error in preparing update order statement
                    die('MySQL error: ' . $conn->error);
                }

                // Bind parameters and execute
                $stmt_update_order->bind_param("i", $order_id);
                $stmt_update_order->execute();

                // Display a confirmation message
                echo "<h2>Order Confirmed</h2>";
                echo "<p>Your payment has been successfully processed. You bought " . $uc_amount . " UC for RM " . $price . ".</p>";
                echo "<p>Transaction ID: " . $transaction_id . "</p>";
            } else {
                echo "<p>Error processing payment.</p>";
            }
        } else {
            echo "<p>Error creating order.</p>";
        }
    } else {
        echo "<p>Please complete all fields.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}

// Close the database connection
$conn->close();
?>
