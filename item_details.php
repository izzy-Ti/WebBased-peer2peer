<?php
include 'includes/db.php';

if (!isset($_GET['id'])) redirect('index.php');

$stmt = $pdo->prepare("SELECT i.*, u.full_name as provider_name FROM items i JOIN users u ON i.provider_id = u.id WHERE i.id = ?");
$stmt->execute([$_GET['id']]);
$item = $stmt->fetch();

if (!$item) redirect('index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isLoggedIn()) redirect('login.php');

    $start = new DateTime($_POST['start_date']);
    $end = new DateTime($_POST['end_date']);
    $days = $start->diff($end)->days + 1;
    $total = $days * $item['price_per_day'];

    $stmt = $pdo->prepare("INSERT INTO rentals (item_id, consumer_id, total_price, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$item['id'], $_SESSION['user_id'], $total, $_POST['start_date'], $_POST['end_date']]);
    
    $stmt = $pdo->prepare("UPDATE items SET status = 'rented' WHERE id = ?");
    $stmt->execute([$item['id']]);

    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($item['title']); ?> | peer2peer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">peer2peer</a>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
            </div>
        </nav>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px;">
            <div>
                <img src="<?php echo $item['image_url'] ?: 'https://via.placeholder.com/600x400?text=No+Image'; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" style="width: 100%; border-radius: 16px; border: 1px solid var(--border);">
            </div>
            <div>
                <h1 style="font-size: 36px; margin-bottom: 10px;"><?php echo htmlspecialchars($item['title']); ?></h1>
                <p style="color: var(--text-gray); margin-bottom: 20px;">Provided by <span style="color: white; font-weight: 600;"><?php echo htmlspecialchars($item['provider_name']); ?></span></p>
                <div style="background: var(--card-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border);">
                    <p class="card-price" style="font-size: 32px; margin-bottom: 20px;">$<?php echo number_format($item['price_per_day'], 2); ?> <span style="font-size: 16px; color: var(--text-gray);">/ day</span></p>
                    <p style="margin-bottom: 30px; color: var(--text-gray);"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                    
                    <form method="POST">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <p style="font-size: 14px; color: var(--text-gray); margin-bottom: 20px;">Note: Pre-payment will be held by the system until provider approval.</p>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Pay & Request Rental</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
