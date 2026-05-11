<?php
include 'includes/db.php';

if (isLoggedIn()) redirect('index.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        redirect('index.php');
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | peer2peer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">peer2peer</a>
        </nav>

        <div class="auth-form">
            <h2 style="margin-bottom: 20px; text-align: center;">Welcome Back</h2>
            <?php if ($error): ?>
                <p style="color: var(--primary-red); text-align: center; margin-bottom: 15px;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
            <p style="text-align: center; margin-top: 20px; font-size: 14px; color: var(--text-gray);">
                Don't have an account? <a href="register.php" style="color: var(--primary-red); text-decoration: none;">Register</a>
            </p>
        </div>
    </div>
</body>
</html>
