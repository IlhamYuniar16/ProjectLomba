<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();
include 'db/db.php';

$id_pendonor = $_SESSION['user']['id'] ?? null;
$id_pasien = $_GET['id'] ?? '';
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
    VALUES ('$id_pendonor', '$nama_pendonor', '$tanggal_lahir', '$jenis_kelamin', '$tipe_darah', '$rhesus', '$catatan_kesehatan')");

$pendonor_id = mysqli_insert_id($db);

mysqli_query($db, "INSERT INTO pengajuan_donor 
    (id_pendonor, jenis_donor, unit_pmi)
    VALUES ($pendonor_id, '$jenis_donor', '$unit_pmi')");

$getJumlah_pendonor = "SELECT jumlah_pendonor FROM permohonan_pasien WHERE id = $id_pasien";
$run_getJumlah_pendonor = mysqli_query($db, $getJumlah_pendonor);
if($run_getJumlah_pendonor > 0) {
mysqli_query($db, "UPDATE permohonan_pasien 
                           SET jumlah_pendonor = jumlah_pendonor - 1
                           WHERE id = $id_pasien");
} else {
    mysqli_query($db, "UPDATE permohonan_pasien 
                           SET status_pengajuan = 'selesai'
                           WHERE id = $id_pasien");
}

mysqli_commit($db);

echo json_encode(["status" => "success", "message" => "Pendaftaran berhasil dikirim! Silahkan tunggu proses pengecekan data dari kami"]);

?>