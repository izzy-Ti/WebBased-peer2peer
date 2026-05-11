<?php
include 'includes/db.php';

if (isLoggedIn()) redirect('index.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        redirect('login.php');
    } catch (PDOException $e) {
        $error = "Email already exists";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | peer2peer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">peer2peer</a>
        </nav>

        <div class="auth-form">
            <h2 style="margin-bottom: 20px; text-align: center;">Create Account</h2>
            <?php if ($error): ?>
                <p style="color: var(--primary-red); text-align: center; margin-bottom: 15px;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
            </form>
            <p style="text-align: center; margin-top: 20px; font-size: 14px; color: var(--text-gray);">
                Already have an account? <a href="login.php" style="color: var(--primary-red); text-decoration: none;">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
