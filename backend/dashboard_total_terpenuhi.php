<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';

$query_dashboard_total_terpenuhi = "SELECT COALESCE(SUM(status_pengajuan = 'selesai'), 0) AS total_terpenuhi FROM permohonan_pasien";
$run_dashboard_total = mysqli_query($db, $query_dashboard_total_terpenuhi);
$row = mysqli_fetch_assoc($run_dashboard_total);

echo json_encode([
    "status" => "success",
    "data" => $row
]);
?>