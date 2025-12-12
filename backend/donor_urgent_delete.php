<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';
$id = $_GET['id'];
$query_delete_urgent = "DELETE FROM permohonan_pasien WHERE id = $id";
$run_delete_urgent = mysqli_query($db, $query_delete_urgent);

echo json_encode(["status"=>"success","message"=>"Permohonan berhasil dikirim!"]);
?>