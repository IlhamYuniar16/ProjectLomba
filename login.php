<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YogyaLife</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 330px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 18px;
            border: none;
            background: #E53935;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #c62828;
        }

        a {
            display: block;
            margin-top: 15px;
            color: #333;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Login</h2>

    <form action="backend/login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required />

        <input type="password" name="password" placeholder="Password" required />

        <button type="submit" name="login">Masuk</button>
    </form>

    <a href="register.php">Belum punya akun?</a>
</div>

</body>
</html>
