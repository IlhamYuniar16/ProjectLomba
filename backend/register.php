<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

include "db/db.php";
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
    $mail->Username = 'jrssquad155@gmail.com';
    $mail->Password = 'grjxbanodfewlnde';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('jrssquad155@gmail.com', 'Yogyalife');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';
    $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email - Yogyalife</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:30px 10px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background:#c62828;padding:20px;text-align:center;color:#ffffff;">
                            <h1 style="margin:0;">Yogyalife</h1>
                            <p style="margin:5px 0 0;font-size:14px;">
                                Verifikasi Email
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px;color:#333;">
                            <h2 style="margin-top:0;color:#c62828;">
                                Verifikasi Email Anda
                            </h2>

                            <p style="line-height:1.6;">
                                Terima kasih telah mendaftar di <strong>Yogyalife</strong>.
                                Untuk mengaktifkan akun Anda, silakan verifikasi alamat email
                                dengan menekan tombol di bawah ini.
                            </p>

                            <div style="text-align:center;margin:30px 0;">
                                <a href="http://localhost/ProjectLomba/backend/services/verify-email.php?token='.$verify_token.'"
                                   style="background:#c62828;color:#ffffff;
                                          padding:12px 24px;text-decoration:none;
                                          border-radius:6px;font-weight:bold;
                                          display:inline-block;">
                                    Verifikasi Email
                                </a>
                            </div>

                            <p style="font-size:14px;color:#666;line-height:1.6;">
                                Jika Anda tidak merasa mendaftar di Yogyalife,
                                abaikan email ini.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f0f0f0;padding:15px;text-align:center;font-size:12px;color:#777;">
                            © '.date("Y").' Yogyalife. Semua hak dilindungi.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
';
    $mail->send();

    echo json_encode([
        "status"=>"success",
        "message"=>"Registrasi berhasil! Periksa email untuk verifikasi.",
        "token"=>$verify_token
    ]);

} catch (Exception $e) {
    echo json_encode(["status"=>"error","message"=>"Registrasi berhasil tapi gagal mengirim email: " . $mail->ErrorInfo]);
}
