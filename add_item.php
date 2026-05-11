<?php
include 'includes/db.php';

if (!isLoggedIn()) redirect('login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price_per_day'];
    $image = $_POST['image_url'];
    $provider_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO items (provider_id, title, description, price_per_day, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$provider_id, $title, $description, $price, $image]);
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Item | peer2peer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">peer2peer</a>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>

        <div class="auth-form" style="max-width: 600px;">
            <h2 style="margin-bottom: 20px; text-align: center;">List Utility for Rent</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Item Title</label>
                    <input type="text" name="title" required placeholder="e.g. Professional Power Drill">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Price Per Day ($)</label>
                    <input type="number" step="0.01" name="price_per_day" required>
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="url" name="image_url" placeholder="https://example.com/image.jpg">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Post Item</button>
            </form>
        </div>
    </div>
</body>
</html>
