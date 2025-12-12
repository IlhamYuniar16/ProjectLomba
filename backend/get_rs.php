<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
include "db/db.php";
$query = "SELECT nama_rs FROM rumah_sakit ORDER BY nama_rs ASC";
$result = mysqli_query($db, $query);

$nama_rs = [];

while($row = mysqli_fetch_assoc($result)){
    $nama_rs[] = $row;
}

echo json_encode($nama_rs);
?>