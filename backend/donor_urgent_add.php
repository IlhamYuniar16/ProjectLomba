<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';

$id_user = $_SESSION['user']['id'] ?? null;

$nama_pasien = $_POST['nama_pasien'] ?? '';
$lokasi_pasien = $_POST['lokasi_pasien'] ?? '';
$nama_rumah_sakit = $_POST['nama_rumah_sakit'] ?? '';
$golongan_darah = $_POST['golongan_darah'] ?? '';
$rhesus = $_POST['rhesus'] ?? '';
$jumlah_pendonor = $_POST['jumlah_pendonor'] ?? '';
$jenis_donor_darah = $_POST['jenis_donor_darah'] ?? '';


if(!$nama_pasien || !$nama_rumah_sakit || !$lokasi_pasien|| !$golongan_darah || !$rhesus || !$jumlah_pendonor || !$jenis_donor_darah){
    echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
    exit;
}

// Insert data permohonan
$query_permohonan = "INSERT INTO permohonan_pasien 
(id_user, nama_pasien, lokasi_pasien, nama_rumah_sakit, golongan_darah, rhesus, jumlah_pendonor, jenis_donor_darah, status_urgent) 
VALUES 
('$id_user','$nama_pasien','$lokasi_pasien','$nama_rumah_sakit','$golongan_darah','$rhesus','$jumlah_pendonor','$jenis_donor_darah', 'Urgent')";

$run_query_permohonan = mysqli_query($db, $query_permohonan);

if(!$run_query_permohonan){
    echo json_encode(["status"=>"error","message"=>"Gagal mendaftar: ".mysqli_error($db)]);
    exit;
}

echo json_encode(["status"=>"success","message"=>"Permohonan berhasil dikirim!"]);

?>