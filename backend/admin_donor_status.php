<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';

$id_user = $_SESSION['user']['id'] ?? null;
$id = $_GET['id'];
$status_eligible = $_POST['status_eligible'] ?? '';


if(!$status_eligible){
    echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
    exit;
}

$query_permohonan = "UPDATE permohonan_pasien SET status_eligible = '$status_eligible' WHERE id = '$id'";


$run_query_permohonan = mysqli_query($db, $query_permohonan);

if(!$run_query_permohonan){
    echo json_encode(["status"=>"error","message"=>"Gagal mendaftar: ".mysqli_error($db)]);
    exit;
}

echo json_encode(["status"=>"success","message"=>"Permohonan berhasil dikirim!"]);

?>