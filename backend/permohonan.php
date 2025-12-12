<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';
if (!$db) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . mysqli_connect_error()]));
}

//INSERT PROCESS
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// $data = json_decode(file_get_contents("php://input"), true);
$id_user = $_SESSION['user']['id'] ?? null;

$nama_pasien = $_POST['nama_pasien'] ?? '';
$nama_rumah_sakit = $_POST['nama_rumah_sakit'] ?? '';
$lokasi_pasien = $_POST['lokasi_pasien'] ?? '';
$golongan_darah = $_POST['golongan_darah'] ?? '';
$rhesus = $_POST['rhesus'] ?? '';
$jumlah_pendonor = $_POST['jumlah_pendonor'] ?? '';
$jenis_donor_darah = $_POST['jenis_donor_darah'] ?? '';
$foto_formulir_rs = $_FILES['foto_formulir_rs'] ?? '';
$narhub_nama = $_POST['narhub_nama'] ?? '';
$narhub_notel = $_POST['narhub_notel'] ?? '';
$narhub_email = $_POST['narhub_email'] ?? '';

if(!$nama_pasien || !$nama_rumah_sakit || !$lokasi_pasien|| !$golongan_darah || !$rhesus || !$jumlah_pendonor || !$jenis_donor_darah || !$narhub_nama || !$narhub_notel || !$narhub_email){
    echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
    exit;
}

$foto_formulir_rs_path = '';
if(isset($_FILES['foto_formulir_rs']) && $_FILES['foto_formulir_rs']['error'] === 0){
    $filename = time() . '_' . basename($_FILES['foto_formulir_rs']['name']);
    $targetFile = $uploadDir . $filename;

    if(move_uploaded_file($_FILES['foto_formulir_rs']['tmp_name'], $targetFile)){
        $foto_formulir_rs_path = $targetFile;
    } else {
        echo json_encode(["status"=>"error","message"=>"Gagal mengupload file"]);
        exit;
    }
}

var_dump("ID USER:", $id_user);
// Insert data permohonan
$query_permohonan = "INSERT INTO permohonan_pasien 
(id_user, nama_pasien, lokasi_pasien, nama_rumah_sakit, golongan_darah, rhesus, jumlah_pendonor, jenis_donor_darah, foto_formulir_rs, narhub_nama, narhub_notel, narhub_email) 
VALUES 
('$id_user','$nama_pasien','$lokasi_pasien','$nama_rumah_sakit','$golongan_darah','$rhesus','$jumlah_pendonor','$jenis_donor_darah','$foto_formulir_rs_path','$narhub_nama','$narhub_notel','$narhub_email')";

$run_query_permohonan = mysqli_query($db, $query_permohonan);

if(!$run_query_permohonan){
    echo json_encode(["status"=>"error","message"=>"Gagal mendaftar: ".mysqli_error($db)]);
    exit;
}

echo json_encode(["status"=>"success","message"=>"Permohonan berhasil dikirim!"]);
