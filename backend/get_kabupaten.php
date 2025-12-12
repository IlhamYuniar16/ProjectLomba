<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
include "db/db.php";
$query = "SELECT nama_kabupaten FROM kabupaten ORDER BY nama_kabupaten ASC";
$result = mysqli_query($db, $query);

$nama_kabupaten = [];

while($row = mysqli_fetch_assoc($result)){
    $nama_kabupaten[] = $row;
}

echo json_encode($nama_kabupaten);
?>