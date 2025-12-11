<?php
session_start();
include 'db/db.php';

$token = $_GET['token'] ?? null;
$status = 'info';
$message = 'Token tidak ditemukan';

if ($token) {
    $query = mysqli_query($db, "SELECT verify_status FROM users WHERE verify_token='$token' LIMIT 1");
    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        if ($user['verify_status'] == 0) {
            mysqli_query($db, "UPDATE users SET verify_status=1 WHERE verify_token='$token'");
            $status = 'success';
            $message = 'Email berhasil diverifikasi! Silakan login.';
        } else {
            $status = 'info';
            $message = 'Email sudah diverifikasi sebelumnya.';
        }
    } else {
        $status = 'error';
        $message = 'Token tidak valid.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .alert { padding: 20px; border-radius: 5px; margin: 20px auto; width: 80%; max-width: 500px; color: #fff; }
        .success { background-color: #4CAF50; }
        .error { background-color: #f44336; }
        .info { background-color: #2196F3; }
    </style>
</head>
<body>
<div class="alert <?php echo htmlspecialchars($status); ?>">
    <?php echo htmlspecialchars($message); ?>
</div>
<a href="../../index.php">Kembali ke Beranda</a>
</body>
</html>
