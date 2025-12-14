<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';
$search = $_GET['search'] ?? '';
$status_pengajuan = $_GET['status_pengajuan'] ?? '';
$gol_darah = $_GET['gol_darah'] ?? '';
$lokasi_pasien = $_GET['lokasi_pasien'] ?? '';

$query = "SELECT * FROM permohonan_pasien WHERE status_urgent = 'Urgent'";

if($search != '') {
    $search = mysqli_real_escape_string($db, $search);
    $query .= " AND nama_pasien LIKE '%$search%'";
}

if($status_pengajuan != '') {
    $status_pengajuan = mysqli_real_escape_string($db, $status_pengajuan);
    $query .= " AND status_pengajuan = '$status_pengajuan'";
}
if($gol_darah != '') {
    $gol_darah = mysqli_real_escape_string($db, $gol_darah);
    $query .= " AND golongan_darah = '$gol_darah'";
}
if($lokasi_pasien != '') {
    $lokasi_pasien = mysqli_real_escape_string($db, $lokasi_pasien);
    $query .= " AND lokasi_pasien = '$lokasi_pasien'";
}

$query .= " ORDER BY id DESC";

$result = mysqli_query($db, $query);
$data = [];
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);
?>