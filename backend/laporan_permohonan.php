<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';
$search = $_GET['search'] ?? '';

$query_laporan_permohonan = "SELECT * FROM permohonan_pasien";
if($search) {
    $search = mysqli_real_escape_string($db, $search);
    $query_laporan_permohonan .= " WHERE nama_pasien LIKE '%$search%'";
}
$query_laporan_permohonan .= " ORDER BY status_urgent DESC";

$run_laporan_permohonan = mysqli_query($db, $query_laporan_permohonan);

$result = [];
while($row = mysqli_fetch_assoc($run_laporan_permohonan)) {
    $result[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $result
]);
?>