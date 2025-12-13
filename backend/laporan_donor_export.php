<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header("Content-type: application/vnd-ms-excel");
include "db/db.php";

date_default_timezone_set("Asia/Jakarta");

$laporan = $_GET['laporan'] ?? '';

if($laporan == "donor") {
    $date = date("d-M-Y_H-i-s");
    header("Content-Disposition: attachment; filename=Laporan-donor-$date.xls");

    $query = "SELECT pd.*, dp.nama_pendonor, dp.tanggal_lahir, dp.jenis_kelamin, dp.tipe_darah, dp.rhesus, dp.catatan_kesehatan 
            FROM pengajuan_donor pd 
            LEFT JOIN data_pendonor dp ON pd.id_pendonor = dp.id
            ORDER BY pd.id_pengajuan_donor DESC";
    $result = mysqli_query($db, $query);

echo "No\tTanggal\tNama Pendonor\tTanggal Lahir\tJenis Kelamin\tTipe Darah\tRhesus\tRumah Sakit\tStatus Pengajuan\tCatatan Kesehatan\n";

    $no = 1;
    while($row = mysqli_fetch_assoc($result)) {
         echo $no."\t".
         $row['created_at']."\t".
         $row['nama_pendonor']."\t".
         $row['tanggal_lahir']."\t".
         $row['rumah_sakit']."\t".
         $row['jenis_kelamin']."\t".
         $row['tipe_darah']."\t".
         $row['rhesus']."\t".
         $row['status_pengajuan']."\t".
         $row['catatan_kesehatan']."\n";
         $no++;
}
} elseif($laporan == "permohonan") {
    $date = date("d-M-Y_H-i-s");
    header("Content-Disposition: attachment; filename=Laporan-permohonan-$date.xls");
    $query = "SELECT * FROM permohonan_pasien ORDER BY status_urgent";
    $result = mysqli_query($db, $query);

    echo "No\tTanggal\tNama Pasien\tRumah Sakit\tLokasi Pasien\tGolongan Darah\tRhesus\tJumlah Pendonor\tJenis Donor\tStatus Urgent\tStatus\n";

    $no = 1;
    while($row = mysqli_fetch_assoc($result)) {
        echo $no."\t".
            $row['created_at']."\t".
            $row['nama_pasien']."\t".
            $row['nama_rumah_sakit']."\t".
            $row['lokasi_pasien']."\t".
            $row['golongan_darah']."\t".
            $row['rhesus']."\t".
            $row['jumlah_pendonor']."\t".
            $row['jenis_donor_darah']."\t".
            $row['status_urgent']."\t".
            $row['status_pengajuan']."\n";
            $no++;
    }
}
?>