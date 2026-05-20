<?php
include 'includes/db.php';

if (!isLoggedIn()) redirect('login.php');

if (isset($_GET['id'])) {
    $rental_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT r.* FROM rentals r JOIN items i ON r.item_id = i.id WHERE r.id = ? AND i.provider_id = ?");
    $stmt->execute([$rental_id, $user_id]);
    $rental = $stmt->fetch();

    if ($rental) {
        $stmt = $pdo->prepare("UPDATE rentals SET status = 'approved' WHERE id = ?");
        $stmt->execute([$rental_id]);
    }
}

redirect('dashboard.php');
?>
