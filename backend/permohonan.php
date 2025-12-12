<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include 'db/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id_user = $_SESSION['user']['id'];
$nama_pasien = $data['nama_pasien'] ?? '';
$lokasi = $data['lokasi'] ?? '';
$nama_rs = $data['nama_rs'] ?? '';
$rhesus = $data['rhesus'] ?? '';
$jumlah_donor = $data['jumlah_donor'] ?? '';
$jenis_donor_darah = $data['jenis_donor_darah'] ?? '';
$foto_formulir_rs = $data['foto_formulir_rs'] ?? '';
$narhub_nama = $data['narhub_nama'] ?? '';
$nahub_notel = $data['nahub_notel'] ?? '';

if(!$nama_pasien || !$lokasi || !$nama_rs || !$rhesus || !$jumlah_donor || !$rhesus || !$jenis_donor_darah || !$foto_formulir_rs || !$narhub_nama || !$nahub_notel || !$narhub_email){
    echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
    exit;
}

$query_permohonan = "INSERT INTO permohonan_pasien (id_user, nama_pasien,lokasi,nama_rs,rhesus,jumlah_donor,jenis_donor_darah,foto_formulir_rs,narhub_nama,nahub_notel,narhub_email) 
          VALUES ('$id_user','$nama_pasien','$lokasi','$nama_rs','$jumlah_donor','$jenis_donor_darah','$foto_formulir_rs','$narhub_nama','$narhub_nama','$nahub_notel','$narhub_email')";
$run_query_permohonan = mysqli_query($db, $query_permohonan);

if(!$run_query_permohonan){
    echo json_encode(["status"=>"error","message"=>"Gagal mendaftar: ".mysqli_error($db)]);
    exit;
}


?>