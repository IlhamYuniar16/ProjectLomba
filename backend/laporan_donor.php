<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$gol_darah = $_GET['gol_darah'] ?? '';
$jenis_donor = $_GET['jenis_donor'] ?? '';

$query_donor = "SELECT * FROM pengajuan_donor pd 
                LEFT JOIN data_pendonor dp ON pd.id_pendonor = dp.id_user 
                WHERE 1=1";

if($search != '') {
    $search = mysqli_real_escape_string($db, $search);
    $query_donor .= " AND dp.nama_pendonor LIKE '%$search%'";
}
if($status != '') {
    $status = mysqli_real_escape_string($db, $status);
    $query_donor .= " AND pd.status_pengajuan = '$status'";
}
if($gol_darah != '') {
    $gol_darah = mysqli_real_escape_string($db, $gol_darah);
    $query_donor .= " AND dp.tipe_darah = '$gol_darah'";
}
if($jenis_donor != '') {
    $jenis_donor = mysqli_real_escape_string($db, $jenis_donor);
    $query_donor .= " AND pd.jenis_donor = '$jenis_donor'";
}

$query_donor .= " ORDER BY pd.id_pengajuan_donor DESC";

$result = mysqli_query($db, $query_donor);
$data = [];
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

?>