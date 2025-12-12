<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
session_start();
include 'db/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$query = mysqli_query($db, "SELECT id, name, email, password, role FROM users WHERE email='$email' LIMIT 1");

if(mysqli_num_rows($query) > 0){
    $user = mysqli_fetch_assoc($query);
    
    if(password_verify($password, $user['password'])){
        // simpan session
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
    echo json_encode(["status"=>"error","message"=>"Email tidak ditemukan"]);
}
exit();
?>
