<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

include 'db/db.php';

$search = $_GET['search'] ?? '';
$status_pengajuan = $_GET['status_pengajuan'] ?? '';
$status_urgent = $_GET['status_urgent'] ?? '';
$gol_darah = $_GET['gol_darah'] ?? '';
$jenis_donor = $_GET['jenis_donor'] ?? '';

$query = "SELECT * FROM permohonan_pasien WHERE 1=1";

if($search != '') {
    $search = mysqli_real_escape_string($db, $search);
    $query .= " AND nama_pasien LIKE '%$search%'";
}

if($status_pengajuan != '') {
    $status_pengajuan = mysqli_real_escape_string($db, $status_pengajuan);
    $query .= " AND status_pengajuan = '$status_pengajuan'";
}

if($status_urgent != '') {
    $status_urgent = mysqli_real_escape_string($db, $status_urgent);
    $query .= " AND status_urgent = '$status_urgent'";
}
if($gol_darah != '') {
    $gol_darah = mysqli_real_escape_string($db, $gol_darah);
    $query .= " AND golongan_darah = '$gol_darah'";
}
if($jenis_donor != '') {
    $jenis_donor = mysqli_real_escape_string($db, $jenis_donor);
    $query .= " AND jenis_donor_darah = '$jenis_donor'";
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
