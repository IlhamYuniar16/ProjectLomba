<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';
$search = $_GET['search'] ?? '';

$query_darurat = "SELECT * FROM permohonan_pasien WHERE status_urgent = 'Urgent'";
if($search) {
    $search = mysqli_real_escape_string($db, $search);
    $query_darurat .= " AND nama_pasien LIKE '%$search%'";
}
$query_darurat .= " ORDER BY id DESC";

$run_darurat = mysqli_query($db, $query_darurat);

$result = [];
while($row = mysqli_fetch_assoc($run_darurat)) {
    $result[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $result
]);
?>