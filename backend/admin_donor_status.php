<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();
use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';
include 'db/db.php';

$id = $_GET['id'];
$tanggal = $_POST['tanggal'] ?? '';
$jam = $_POST['jam'] ?? '';
$status_pengajuan = $_POST['status_pengajuan'] ?? '';

if(!$status_pengajuan){
    echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
    exit;
}

$query_permohonan = "UPDATE pengajuan_donor SET status_pengajuan = '$status_pengajuan' WHERE id = '$id'";
$run_query_permohonan = mysqli_query($db, $query_permohonan);

if(!$run_query_permohonan){
    echo json_encode(["status"=>"error","message"=>"Gagal mendaftar: ".mysqli_error($db)]);
    exit;
}


if ($status_pengajuan === "eligible") {

    $q = mysqli_query(
        $db,
        "SELECT u.email
        FROM pengajuan_donor pd
        JOIN data_pendonor dp ON pd.id_pendonor = dp.id
        JOIN users u ON dp.id_user = u.id
        WHERE pd.id_pengajuan_donor = '$id'
"
    );

    $row = mysqli_fetch_assoc($q);
    $email = $row['email'] ?? '';

    if ($email) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rizktc@gmail.com';
            $mail->Password = 'thunmchajcrfkpir';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('rizktc@gmail.com', 'Yogyalife');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Undangan Donor Darah Yogyalife';
            $mail->Body = "
                <h3>Pengajuan Anda Diterima</h3>
                <p>Tanggal: <b>$tanggal</b></p>
                <p>Jam: <b>$jam</b></p>
            ";
            $mail->send();
        } catch (Exception $e) {}
    }
}

echo json_encode([
    "status"=>"success",
    "message"=>"Status berhasil diperbarui"
]);
?>