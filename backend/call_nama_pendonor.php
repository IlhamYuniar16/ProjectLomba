<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';

if(!isset($_SESSION['user'])){
    echo json_encode(["status"=>"error","message"=>"Belum login"]);
    exit;
}

echo json_encode([
    "status" => "success",
    "user" => $_SESSION['user']
]);
?>