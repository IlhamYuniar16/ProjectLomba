<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include 'db/db.php';
use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';

// Ambil data dari JSON
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!$email || !$password) {
    echo json_encode([
        "status" => "error",
        "message" => "Email atau password kosong!"
    ]);
    exit;
}

// Cek apakah email sudah ada
$check = mysqli_query($db, "SELECT email FROM users WHERE email='$email' LIMIT 1");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(["status" => "error", "message" => "Email sudah terdaftar"]);
    exit;
}

// Generate token verifikasi
$verify_token = md5(rand());

// Simpan user
$hash_password = password_hash($password, PASSWORD_DEFAULT); // hash password
$query = "INSERT INTO users (email, password, verify_token) VALUES ('$email', '$hash_password', '$verify_token')";
$run = mysqli_query($db, $query);

if ($run) {
    // Kirim email verifikasi
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rizktc@gmail.com';  // ganti dengan emailmu
        $mail->Password = 'thunmchajcrfkpir';  // ganti dengan app password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('rizktc@gmail.com', "Chandra");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification from Chandra';
        $mail->Body = "
            <h2>Verify your email address:</h2>
            <a href='http://localhost:8000/backend/services/verify-email.php?token=$verify_token'>Click here to verify</a>
        ";

        $mail->send();
        echo json_encode(["status"=>"success","message"=>"Registrasi berhasil! Periksa email untuk verifikasi."]);


    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Registrasi berhasil tapi gagal mengirim email: " . $mail->ErrorInfo
        ]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Gagal mendaftar"]);
}
