<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';

$query_laporan_donor = "SELECT pd.*, dp.nama_pendonor, dp.tanggal_lahir, dp.jenis_kelamin, dp.tipe_darah, dp.rhesus, dp.catatan_kesehatan 
                         FROM pengajuan_donor pd LEFT JOIN data_pendonor dp 
                         ON pd.id_pendonor = dp.id_user ORDER BY pd.id_pengajuan_donor DESC";
$run_laporan_donor = mysqli_query($db, $query_laporan_donor);

$result = [];
while($row = mysqli_fetch_assoc($run_laporan_donor)) {
    $result[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $result
]);
?>