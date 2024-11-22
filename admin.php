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

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = true; // Replace with proper authentication logic
}

// Fetch orders
$orderQuery = "
    SELECT o.id AS order_id, u.email, o.uc_amount, o.price, o.payment_method, o.payment_status, o.order_date
    FROM `orders` o
    INNER JOIN `users` u ON o.user_id = u.id
    ORDER BY o.order_date DESC
";

try {
    $orderStmt = $pdo->prepare($orderQuery);
    $orderStmt->execute();
    $orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

    // Ensure $orders is always an array
    if (!$orders) {
        $orders = [];
    }
} catch (Exception $e) {
    die("Error fetching orders: " . $e->getMessage());
}

// Fetch user signup details
$userQuery = "SELECT id, email, role, created_at FROM users ORDER BY created_at DESC";
try {
    $userStmt = $pdo->prepare($userQuery);
    $userStmt->execute();
    $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$users) {
        $users = [];
    }
} catch (Exception $e) {
    die("Error fetching users: " . $e->getMessage());
}

// Fetch login activity
$loginQuery = "
    SELECT la.id AS activity_id, u.email, la.login_time
    FROM login_activity la
    INNER JOIN users u ON la.user_id = u.id
    ORDER BY la.login_time DESC
";
try {
    $loginStmt = $pdo->prepare($loginQuery);
    $loginStmt->execute();
    $logins = $loginStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$logins) {
        $logins = [];
    }
} catch (Exception $e) {
    die("Error fetching login activity: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Track Orders and Users</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        h1, h2 {
            text-align: center;
            margin: 20px 0;
        }

        h1 {
            font-size: 2.5em;
            color: #333;
        }

        h2 {
            font-size: 1.8em;
            color: #444;
        }

        /* Table Styles */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #0078d7;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* No Data Row */
        td[colspan] {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
        }

        /* Section Spacing */
        section {
            margin: 30px auto;
            padding: 20px;
            max-width: 1200px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        footer {
            text-align: center;
            margin: 20px 0;
            color: #777;
            font-size: 14px;
        }

        /* Button Styles */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-buttons a {
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #fff;
            background: linear-gradient(135deg, #4caf50, #2e7d32); /* Green gradient for Login */
            padding: 10px 25px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .action-buttons a:hover {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(46, 125, 50, 0.4);
        }

        .action-buttons a:nth-child(2) {
            background: linear-gradient(135deg, #2196f3, #0d47a1); /* Blue gradient for Index */
        }

        .action-buttons a:nth-child(2):hover {
            background: linear-gradient(135deg, #0d47a1, #2196f3);
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    
    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="login.php">Back to Login</a>
        <a href="index.php">Go to Main Page</a>
    </div>

    <section>
        <h2>Track Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Email</th>
                    <th>UC Amount</th>
                    <th>Price (USD)</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['email']) ?></td>
                            <td><?= htmlspecialchars($order['uc_amount']) ?> UC</td>
                            <td>$<?= htmlspecialchars(number_format($order['price'], 2)) ?></td>
                            <td><?= htmlspecialchars($order['payment_method']) ?></td>
                            <td><?= htmlspecialchars($order['payment_status']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Track User Signups</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Signup Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Track User Logins</h2>
        <table>
            <thead>
                <tr>
                    <th>Activity ID</th>
                    <th>User Email</th>
                    <th>Login Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($logins) > 0): ?>
                    <?php foreach ($logins as $login): ?>
                        <tr>
                            <td><?= htmlspecialchars($login['activity_id']) ?></td>
                            <td><?= htmlspecialchars($login['email']) ?></td>
                            <td><?= htmlspecialchars($login['login_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No login activity found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; <?= date('Y') ?> Admin Dashboard. All Rights Reserved.</p>
    </footer>
</body>
</html>
