<?php
include 'includes/db.php';

if (!isLoggedIn()) redirect('login.php');

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT r.*, i.title, u.full_name as consumer_name FROM rentals r JOIN items i ON r.item_id = i.id JOIN users u ON r.consumer_id = u.id WHERE i.provider_id = ? ORDER BY r.created_at DESC");
$stmt->execute([$user_id]);
$provider_rentals = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT r.*, i.title FROM rentals r JOIN items i ON r.item_id = i.id WHERE r.consumer_id = ? ORDER BY r.created_at DESC");
$stmt->execute([$user_id]);
$my_rentals = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | peer2peer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">peer2peer</a>
            <div class="nav-links">
                <a href="add_item.php">List Item</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>

        <section class="dashboard-section">
            <h2>Rental Requests (Incoming)</h2>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Consumer</th>
                            <th>Dates</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($provider_rentals as $r): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r['title']); ?></td>
                                <td><?php echo htmlspecialchars($r['consumer_name']); ?></td>
                                <td><?php echo $r['start_date']; ?> to <?php echo $r['end_date']; ?></td>
                                <td>$<?php echo $r['total_price']; ?></td>
                                <td><span class="badge badge-<?php echo $r['status']; ?>"><?php echo $r['status']; ?></span></td>
                                <td>
                                    <?php if ($r['status'] === 'pending'): ?>
                                        <a href="approve.php?id=<?php echo $r['id']; ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Approve & Release Funds</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="dashboard-section">
            <h2>My Rentals (Outgoing)</h2>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Dates</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($my_rentals as $r): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r['title']); ?></td>
                                <td><?php echo $r['start_date']; ?> to <?php echo $r['end_date']; ?></td>
                                <td>$<?php echo $r['total_price']; ?></td>
                                <td><span class="badge badge-<?php echo $r['status']; ?>"><?php echo $r['status']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
