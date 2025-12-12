<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include 'db/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$tanggal_lahir = $data['tanggal_lahir'] ?? '';
$jenis_kelamin = $data['jenis_kelamin'] ?? '';
$tipe_darah = $data['tipe_darah'] ?? '';
$rhesus = $data['rhesus'] ?? '';
$catatan_kesehatan = $data['catatan_kesehatan'] ?? '';
$jenis_donor = $data['jenis_donor'] ?? '';
$rumah_sakit = $data['rumah_sakit'] ?? '';

if(!$tanggal_lahir || !$jenis_kelamin || !$tipe_darah || !$rhesus || !$catatan_kesehatan || !$jenis_donor || !$rumah_sakit){
    echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
    exit;
}

mysqli_begin_transaction($db);
mysqli_query($db, "INSERT INTO data_pendonor (id_user, tanggal_lahir, jenis_kelamin, tipe_darah, rhesus, catatan_kesehatan)
                   VALUES ('$id_user', '$tanggal_lahir', '$jenis_kelamin', '$tipe_darah', '$rhesus', '$catatan_kesehatan')");
$pendonor_id = mysqli_insert_id($db);
mysqli_query($db, "INSERT INTO pengajuan_donor (id_pendonor, jenis_donor, rumah_sakit)
                   VALUES ($pendonor_id, '$jenis_donor', '$rumah_sakit')");
mysqli_commit($db);



?>