<?php
session_start();
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
<a href="http://localhost:5173/masuk">Kembali ke Beranda</a>
</body>
</html>
