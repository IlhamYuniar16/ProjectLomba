<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';

// OPTIONS request untuk CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$query = mysqli_query($db, "SELECT id, name, email, password, role, verify_status FROM users WHERE email='$email' LIMIT 1");

if(mysqli_num_rows($query) > 0){
    $user = mysqli_fetch_array($query);

    if($user['verify_status'] == 1){

        if(password_verify($password, $user['password'])){
            $_SESSION['user'] = [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "role" => $user['role']
            ];

            echo json_encode([
                "status" => "success",
                "message" => "Login berhasil",
                "user" => $_SESSION['user']
            ]);
        } else {
            echo json_encode(["status"=>"error","message"=>"Password salah"]);
        }

    } else {
        echo json_encode(["status"=>"error","message"=>"Please verify your account"]);
    }

} else {
    echo json_encode(["status"=>"error","message"=>"Email tidak ditemukan"]);
}

exit();
