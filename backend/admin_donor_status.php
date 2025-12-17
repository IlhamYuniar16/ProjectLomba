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

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  http_response_code(403);
  echo json_encode([
    'status' => 'forbidden',
    'message' => 'Akses ditolak'
  ]);
  exit;
}

$id = $_GET['id'];
$tanggal = $_POST['tanggal'] ?? '';
$format_tanggal = date('d-m-Y', strtotime($tanggal));
$jam = $_POST['jam'] ?? '';
$status_pengajuan = $_POST['status_pengajuan'] ?? '';


if($status_pengajuan === 'eligible') {
    if(!$status_pengajuan || !$tanggal || !$jam){
        echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
        exit;
    } else {
        if(!$status_pengajuan) {
            echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi!"]);
            exit;
        }
    }
}

$query_permohonan = "UPDATE pengajuan_donor SET status_pengajuan = '$status_pengajuan' WHERE id_pengajuan_donor  = '$id'";
$run_query_permohonan = mysqli_query($db, $query_permohonan);

if(!$run_query_permohonan){
    echo json_encode(["status"=>"error","message"=>"Gagal edit: ".mysqli_error($db)]);
    exit;
}
if($status_pengajuan === 'eligible') {
$q = mysqli_query(
        $db,
        "SELECT u.email, pd.unit_pmi, dp.nama_pendonor
        FROM pengajuan_donor pd
        JOIN data_pendonor dp ON pd.id_pendonor = dp.id
        JOIN users u ON dp.id_user = u.id
        WHERE pd.id_pengajuan_donor = '$id'"
    );

    $row = mysqli_fetch_assoc($q);
    $email = $row['email'] ?? '';
    $lokasi = $row['unit_pmi'] ?? '';
    $nama_pendonor = $row['nama_pendonor'] ?? '';
    if ($email) {
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
            $mail->Subject = 'Surat Undangan Donor Darah Yogyalife';
            $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Undangan Donor Darah</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:30px 10px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background:#c62828;padding:20px;text-align:center;color:#ffffff;">
                            <h1 style="margin:0;font-size:24px;">Yogyalife</h1>
                            <p style="margin:5px 0 0;font-size:14px;">
                                Undangan Donor Darah
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px;color:#333333;">
                            <h2 style="margin-top:0;color:#c62828;">
                                Pengajuan Donor Darah Anda Diterima
                            </h2>

                            <p style="line-height:1.6;">
                                Kami mengundang Anda untuk ikut serta dalam kegiatan 
                                <strong>Donor Darah</strong> yang akan diselenggarakan oleh 
                                <strong>Yogyalife</strong>.
                            </p>

                            <p style="line-height:1.6;">
                                Setetes darah Anda dapat menjadi harapan bagi mereka yang membutuhkan.
                                Setiap donor yang Anda lakukan berarti telah membantu menyelamatkan nyawa.
                            </p>

                            <table cellpadding="0" cellspacing="0" style="margin-top:20px;">
                                <tr>
                                    <td style="padding:6px 0;"><strong>Nama Pendonor</strong></td>
                                    <td style="padding:6px 10px;">:</td>
                                    <td style="padding:6px 0;">'.$nama_pendonor.'</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;"><strong>Tanggal</strong></td>
                                    <td style="padding:6px 10px;">:</td>
                                    <td style="padding:6px 0;">'.$format_tanggal.'</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;"><strong>Jam</strong></td>
                                    <td style="padding:6px 10px;">:</td>
                                    <td style="padding:6px 0;">'.$jam.'</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;"><strong>Lokasi</strong></td>
                                    <td style="padding:6px 10px;">:</td>
                                    <td style="padding:6px 0;">'.$lokasi.'</td>
                                </tr>
                            </table>

                            <p style="margin-top:25px;line-height:1.6;">
                                Mohon datang tepat waktu dan pastikan kondisi kesehatan Anda dalam keadaan baik.
                            </p>

                            <p style="margin-top:30px;">
                                Terima kasih atas partisipasi dan kepedulian Anda.
                            </p>

                            <p style="margin-top:10px;">
                                Hormat kami,<br>
                                <strong>Tim Yogyalife</strong>
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
        } catch (Exception $e) {}
    }

}


echo json_encode([
    "status"=>"success",
    "message"=>"Status berhasil diperbarui"
]);
?>