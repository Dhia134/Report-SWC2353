<?php
// Include database connection
include('db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weapons Showcase</title>
    <link rel="stylesheet" href="style.css"> <!-- Replace with your CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #111;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            color: #FFD700;
            font-size: 2em;
        }

        .weapons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .weapon-card {
            background: #222;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            position: relative;
        }

        .weapon-card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 5px;
        }

        .weapon-card h3 {
            margin: 10px 0 5px;
            font-size: 1.2em;
            color: #FFD700;
        }

        .weapon-card button {
            margin-top: 10px;
            padding: 8px 15px;
            background: #FFD700;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .weapon-card button:hover {
            background: #fff;
            color: #000;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 600px;
            background: #222;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            padding: 20px;
        }

        .modal.active {
            display: block;
        }

        .modal h2 {
            color: #FFD700;
            margin-top: 0;
        }

        .modal p {
            color: #ccc;
        }

        .modal button {
            margin-top: 20px;
            padding: 8px 15px;
            background: #FFD700;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal button:hover {
            background: #fff;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>

<header class="header">
    <h1>Weapons Showcase</h1>
</header>

<section class="weapons-grid">
    <?php
    // Fetch weapons from database
    $result = $conn->query("SELECT * FROM weapons");
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="weapon-card">
            <img src="' . $row['image'] . '" alt="' . $row['name'] . '">
            <h3>' . $row['name'] . '</h3>
            <button onclick="showDetails(\'' . $row['name'] . '\', \'' . addslashes($row['description']) . '\')">Details</button>
        </div>';
    }
    ?>
</section>

<!-- Modal -->
<div class="overlay" id="overlay"></div>
<div class="modal" id="modal">
    <h2 id="modal-title"></h2>
    <p id="modal-description"></p>
    <button onclick="closeModal()">Close</button>
</div>

<script>
    function showDetails(name, description) {
        document.getElementById('modal-title').innerText = name;
        document.getElementById('modal-description').innerText = description;
        document.getElementById('modal').classList.add('active');
        document.getElementById('overlay').classList.add('active');
    }

    function closeModal() {
        document.getElementById('modal').classList.remove('active');
        document.getElementById('overlay').classList.remove('active');
    }
</script>

</body>

<footer>
<?php include 'footer.php'; ?>

</footer>
</html>

