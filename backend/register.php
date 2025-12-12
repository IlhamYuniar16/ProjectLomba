<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");


use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';

// Ambil data JSON dari Vue
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$konfirmasipassword = $data['konfirmasipassword'] ?? '';

// Validasi
if(!$name || !$email || !$password || !$konfirmasipassword){
    echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
    exit;
}

if($password !== $konfirmasipassword){
    echo json_encode(["status"=>"error","message"=>"Password tidak sama!"]);
    exit;
}

// Cek email
$check = mysqli_query($db, "SELECT email FROM users WHERE email='$email'");
if(mysqli_num_rows($check) > 0){
    echo json_encode(["status"=>"error","message"=>"Email sudah terdaftar"]);
    exit;
}

// Simpan user
$hash_password = password_hash($password, PASSWORD_DEFAULT);
$verify_token = md5(rand());
$query = "INSERT INTO users (name,email,password,verify_token) VALUES ('$name','$email','$hash_password','$verify_token')";
$run = mysqli_query($db, $query);

if(!$run){
    echo json_encode(["status"=>"error","message"=>"Gagal mendaftar: ".mysqli_error($db)]);
    exit;
}

// Kirim email verifikasi
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'rizktc@gmail.com';
    $mail->Password = 'thunmchajcrfkpir';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('rizktc@gmail.com', "Chandra");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';
    $mail->Body = "<h2>Verify your email:</h2>
        <a href='http://localhost/ProjectLomba/backend/services/verify-email.php?token=$verify_token'>Klik disini</a>";
    $mail->send();

    echo json_encode([
        "status"=>"success",
        "message"=>"Registrasi berhasil! Periksa email untuk verifikasi.",
        "token"=>$verify_token
    ]);

} catch (Exception $e) {
    echo json_encode(["status"=>"error","message"=>"Registrasi berhasil tapi gagal mengirim email: " . $mail->ErrorInfo]);
}
