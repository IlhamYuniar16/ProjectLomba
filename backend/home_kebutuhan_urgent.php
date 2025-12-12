<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';
$search = $_GET['search'] ?? '';
$query_dashboard_kebutuhan_urgent = "SELECT id, nama_pasien, lokasi_pasien, golongan_darah, status_urgent FROM permohonan_pasien WHERE status_urgent='Urgent'";
if($search) {
    $search = mysqli_real_escape_string($db, $search);
    $query_dashboard_kebutuhan_urgent .= " AND nama_pasien LIKE '%$search%'";
}
$query_dashboard_kebutuhan_urgent .= " ORDER BY id DESC";

$run_dashboard_kebutuhan_urgent = mysqli_query($db, $query_dashboard_kebutuhan_urgent);



$result = [];

while($row = mysqli_fetch_assoc($run_dashboard_kebutuhan_urgent)) {
    $result[] = $row;
}

echo json_encode([
    "status" => "success",
    "data"   => $result
]);
?>