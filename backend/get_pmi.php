<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
include "db/db.php";
$query = "SELECT unit_pmi FROM unit_pmi";
$result = mysqli_query($db, $query);

$unit_pmi = [];

while($row = mysqli_fetch_assoc($result)){
    $unit_pmi[] = $row;
}

echo json_encode($unit_pmi);
?>