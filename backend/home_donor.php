<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';

$id_user = $_SESSION['user']['id'] ?? null;
$nama_pendonor = $_POST['nama_pendonor'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$tipe_darah = $_POST['tipe_darah'] ?? '';
$rhesus = $_POST['rhesus'] ?? '';
$catatan_kesehatan = $_POST['catatan_kesehatan'] ?? '';
$jenis_donor = $_POST['jenis_donor'] ?? '';
$unit_pmi = $_POST['unit_pmi'] ?? '';

if (!$nama_pendonor || !$tanggal_lahir || !$jenis_kelamin || !$tipe_darah || 
    !$rhesus || !$catatan_kesehatan || !$jenis_donor || !$unit_pmi) {
    echo json_encode(["status" => "error", "message" => "Semua field wajib diisi!"]);
    exit;
}

mysqli_begin_transaction($db);

mysqli_query($db, "INSERT INTO data_pendonor 
    (id_user, nama_pendonor, tanggal_lahir, jenis_kelamin, tipe_darah, rhesus, catatan_kesehatan)
    VALUES ('$id_user', '$nama_pendonor', '$tanggal_lahir', '$jenis_kelamin', '$tipe_darah', '$rhesus', '$catatan_kesehatan')");

$pendonor_id = mysqli_insert_id($db);

mysqli_query($db, "INSERT INTO pengajuan_donor 
    (id_pendonor, jenis_donor, unit_pmi)
    VALUES ($pendonor_id, '$jenis_donor', '$unit_pmi')");

mysqli_query($db, "UPDATE unit_pmi 
                           SET stok_darah = stok_darah + 1
                           WHERE unit_pmi = '$unit_pmi'");

mysqli_commit($db);

echo json_encode(["status" => "success", "message" => "Pendaftaran berhasil dikirim! Silahkan tunggu proses pengecekan data dari kami"]);
?>