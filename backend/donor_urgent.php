<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include 'db/db.php';

// query ke database
$sql_kebutuhan = "SELECT id, nama_pasien, lokasi_pasien, golongan_darah, status_urgent, status_pengajuan FROM permohonan_pasien WHERE status_pengajuan = 'diterima' ORDER BY status_urgent = 'Urgent' DESC";
$result_kebutuhan = mysqli_query($db, $sql);

$kebutuhan = [];
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $kebutuhan[] = $row;
    }
}

echo json_encode($kebutuhan);

?>
?>