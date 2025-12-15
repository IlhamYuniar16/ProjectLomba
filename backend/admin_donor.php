<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';

$query_donor = "SELECT * FROM pengajuan_donor pd 
                LEFT JOIN data_pendonor dp ON pd.id_pendonor = dp.id 
                WHERE 1=1 ORDER BY pd.id_pengajuan_donor DESC";

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

