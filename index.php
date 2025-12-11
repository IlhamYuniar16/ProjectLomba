<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YogyaLife</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
            width: 320px;
        }

        h1 {
            margin-bottom: 25px;
            color: #444;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s;
        }

        .login-btn {
            background: #E53935;
            color: white;
        }

        .login-btn:hover {
            background: #c62828;
        }

        .register-btn {
            background: #4CAF50;
            color: white;
        }

        .register-btn:hover {
            background: #388e3c;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>YogyaLife</h1>
    <?php
    if(isset($_SESSION['status']) && $_SESSION['status'] != '') {
        echo '<div class="alert alert-info">'.$_SESSION['status'].'</div>';
        unset($_SESSION['status']);
    }
    ?>
    <button class="login-btn" onclick="window.location.href='login.php'">
        Login
    </button>

    <button class="register-btn" onclick="window.location.href='register.php'">
        Register
    </button>
</div>

</body>
</html>
