<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
session_start();
include 'db/db.php';
$id = $_GET['id'] ?? '';

$query = "SELECT * FROM permohonan_pasien WHERE id = $id";
$run = mysqli_query($db, $query);
$data = [];
while($row = mysqli_fetch_assoc($run)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

?>