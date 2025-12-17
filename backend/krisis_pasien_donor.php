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
$merokok = $_POST['merokok'] ?? '';
$alkohol = $_POST['alkohol'] ?? '';
$olahraga = $_POST['olahraga'] ?? '';
$berat_badan = $_POST['berat_badan'] ?? '';

if (!$nama_pendonor || !$tanggal_lahir || !$jenis_kelamin || !$tipe_darah || 
    !$rhesus || !$catatan_kesehatan || !$jenis_donor || !$unit_pmi || !$merokok || !$alkohol || !$olahraga || !$berat_badan) {
    echo json_encode(["status" => "error", "message" => "Semua field wajib diisi!"]);
    exit;
}

mysqli_begin_transaction($db);

mysqli_query($db, "INSERT INTO data_pendonor 
    (id_user, nama_pendonor, tanggal_lahir, jenis_kelamin, tipe_darah, rhesus, catatan_kesehatan, merokok, alkohol, olahraga, berat_badan, keterangan)
    VALUES ('$id_pendonor', '$nama_pendonor', '$tanggal_lahir', '$jenis_kelamin', '$tipe_darah', '$rhesus', '$catatan_kesehatan', '$merokok', '$alkohol', '$olahraga', '$berat_badan', 'Khusus')");

$pendonor_id = mysqli_insert_id($db);

mysqli_query($db, "INSERT INTO pengajuan_donor 
    (id_pendonor, jenis_donor, unit_pmi)
    VALUES ($pendonor_id, '$jenis_donor', '$unit_pmi')");

$getJumlah_pendonor = "SELECT jumlah_pendonor FROM permohonan_pasien WHERE id = $id_pasien";
$run_getJumlah_pendonor = mysqli_query($db, $getJumlah_pendonor);
$row = mysqli_fetch_assoc($run_getJumlah_pendonor);
if($row['jumlah_pendonor'] > 0) {
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