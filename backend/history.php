<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include 'db/db.php';

// cek apakah user sudah login
if(!isset($_SESSION['user'])) {
    die("Anda belum login");
}

$id_user = $_SESSION['user']['id']; // ambil id_user dari session

// query ke database
$sql_history = "SELECT nama_pasien, golongan_darah, created_at, status_pengajuan FROM permohonan_pasien WHERE id_user = $id_user ORDER BY created_at DESC";
$result_history = mysqli_query($db, $sql);

$permohonan = [];
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $permohonan[] = $row;
    }
}

echo json_encode($permohonan);

?>