<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';

if (!isset($_SESSION['user'])) {
    echo json_encode([
        "status" => "unauthorized",
        "data" => []
    ]);
    exit;
}

$id_user = (int) $_SESSION['user']['id'];

$query = "SELECT 
    dp.nama_pendonor AS nama_pendonor,
    dp.tipe_darah AS tipe_darah,
    DATE_FORMAT(dp.created_at, '%d %b %Y') AS tanggal,
    pd.jenis_donor AS jenis_donor,
    pd.status_pengajuan AS status_pengajuan
FROM data_pendonor dp
JOIN pengajuan_donor pd 
    ON pd.id_pendonor = dp.id
WHERE dp.id_user = $id_user ORDER BY id DESC";

$result = mysqli_query($db, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);