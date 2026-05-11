<?php
$host = 'aws-0-eu-west-1.pooler.supabase.com';
$db = 'postgres';
$user = 'postgres.kcexddcloyuwtjurlosm';
$pass = 'xk5Db-rHT@Uuh@w';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}
?>
