<?php
include 'includes/db.php';

$stmt = $pdo->query("SELECT i.*, u.full_name as provider_name FROM items i JOIN users u ON i.provider_id = u.id WHERE i.status = 'available' ORDER BY i.created_at DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>peer2peer | Rent Utilities</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">peer2peer</a>
            <div class="nav-links">
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="add_item.php">List Item</a>
                    <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['full_name']); ?>)</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php" class="btn btn-outline">Register</a>
                <?php endif; ?>
            </div>
        </nav>

        <header class="hero">
            <h1>Rent <span>Anything</span> from Anyone.</h1>
            <p>Peer to peer utility lending made simple and secure.</p>
        </header>

        <section>
            <h2 style="margin-bottom: 30px;">Available Utilities</h2>
            <div class="grid">
                <?php foreach ($items as $item): ?>
                    <div class="card">
                        <img src="<?php echo $item['image_url'] ?: 'https://via.placeholder.com/300x200?text=No+Image'; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="card-img">
                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p style="color: var(--text-gray); font-size: 14px; margin-bottom: 10px;">By <?php echo htmlspecialchars($item['provider_name']); ?></p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <p class="card-price">$<?php echo number_get_formatted($item['price_per_day'], 2); ?> <span style="font-size: 12px; color: var(--text-gray);">/ day</span></p>
                                <a href="item_details.php?id=<?php echo $item['id']; ?>" class="btn btn-primary">Rent Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>
<?php
function number_get_formatted($num) {
    return number_format($num, 2);
}
?>
