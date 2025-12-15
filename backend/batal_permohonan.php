<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

session_start();
include 'db/db.php';

$id_user = $_SESSION['user']['id'];
$id = $_GET['id'] ?? null;
$status_pengajuan = $_POST['status_pengajuan'] ?? null;

if (!$id || !$status_pengajuan) {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap",
        "debug" => [
            "id" => $id,
            "post" => $_POST
        ]
    ]);
    exit;
}

$query = "
UPDATE permohonan_pasien
SET status_pengajuan = '$status_pengajuan'
WHERE id = $id
AND id_user = $id_user
";

if (!mysqli_query($db, $query)) {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($db)
    ]);
    exit;
}

if (mysqli_affected_rows($db) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Permohonan tidak ditemukan atau bukan milik Anda"
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "message" => "Permohonan berhasil dibatalkan"
]);
