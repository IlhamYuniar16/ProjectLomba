<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
session_start();

include 'db/db.php';

// QUERY CARD
$query_dashboard_total_permintaan = "SELECT COUNT(*) AS total_permintaan FROM permohonan_pasien WHERE status_pengajuan = 'diterima'";
$run_dashboard_total_permintaan = mysqli_query($db, $query_dashboard_total_permintaan);
$row_total_permintaan = mysqli_fetch_assoc($run_dashboard_total_permintaan);

$query_dashboard_total_terpenuhi = "SELECT COUNT(*) AS total_terpenuhi FROM permohonan_pasien WHERE status_pengajuan = 'selesai'";
$run_dashboard_total_terpenuhi = mysqli_query($db, $query_dashboard_total_terpenuhi);
$row_total_terpenuhi = mysqli_fetch_assoc($run_dashboard_total_terpenuhi);

$query_dashboard_total_darah = "SELECT COALESCE(SUM(stok_darah), 0) AS stok_darah FROM unit_pmi";
$run_dashboard_total_darah = mysqli_query($db, $query_dashboard_total_darah);
$row_total_darah = mysqli_fetch_assoc($run_dashboard_total_darah);

$query_dashboard_total_batal = "SELECT COUNT(*) AS total_batal FROM permohonan_pasien WHERE status_pengajuan = 'batal'";
$run_dashboard_total_batal = mysqli_query($db, $query_dashboard_total_batal);
$row_total_batal = mysqli_fetch_assoc($run_dashboard_total_batal);

// QUERY CHART
$query_chart_tipe_darah = "
    SELECT 
    pd.status_pengajuan,
    SUM(CASE WHEN dp.tipe_darah = 'A' THEN 1 ELSE 0 END) AS A,
    SUM(CASE WHEN dp.tipe_darah = 'B' THEN 1 ELSE 0 END) AS B,
    SUM(CASE WHEN dp.tipe_darah = 'AB' THEN 1 ELSE 0 END) AS AB,
    SUM(CASE WHEN dp.tipe_darah = 'O' THEN 1 ELSE 0 END) AS O
    FROM pengajuan_donor pd JOIN data_pendonor dp ON dp.id = pd.id_pengajuan_donor WHERE pd.status_pengajuan = 'eligible'
";
$row_chart_tipe_darah = mysqli_fetch_assoc(mysqli_query($db, $query_chart_tipe_darah));


$query_chart_jenis_kelamin = "
    SELECT 
    pd.status_pengajuan,
    SUM(CASE WHEN dp.jenis_kelamin = 'laki-laki' THEN 1 ELSE 0 END) AS Lakilaki,
    SUM(CASE WHEN dp.jenis_kelamin = 'perempuan' THEN 1 ELSE 0 END) AS Perempuan
    FROM pengajuan_donor pd JOIN data_pendonor dp ON dp.id = pd.id_pengajuan_donor WHERE pd.status_pengajuan = 'eligible'
";
$row_chart_jenis_kelamin = mysqli_fetch_assoc(mysqli_query($db,$query_chart_jenis_kelamin));

$query_chart_kebutuhan_kab = "
    SELECT 
    SUM(CASE WHEN lokasi_pasien = 'Kulon Progo' THEN 1 ELSE 0 END) AS kulon_progo,
    SUM(CASE WHEN lokasi_pasien = 'Bantul' THEN 1 ELSE 0 END) AS bantul,
    SUM(CASE WHEN lokasi_pasien = 'Gunung Kidul' THEN 1 ELSE 0 END) AS gunung_kidul,
    SUM(CASE WHEN lokasi_pasien = 'Sleman' THEN 1 ELSE 0 END) AS sleman,
    SUM(CASE WHEN lokasi_pasien = 'Kota Yogyakarta' THEN 1 ELSE 0 END) AS yogyakarta,
    SUM(CASE WHEN lokasi_pasien = 'DI Yogyakarta' THEN 1 ELSE 0 END) AS diyogyakarta
    FROM permohonan_pasien WHERE status_pengajuan = 'diterima'
";
$row_chart_kebutuhan_kab = mysqli_fetch_assoc(mysqli_query($db,$query_chart_kebutuhan_kab));

// QUERY TABEL
$query_pendonor = " SELECT * FROM pengajuan_donor pd 
                    LEFT JOIN data_pendonor dp ON pd.id_pendonor = dp.id 
                    WHERE 1=1 ORDER BY pd.id_pengajuan_donor DESC";
$run_pendonor = mysqli_query($db, $query_pendonor);
$data_pendonor = [];
while($row_pendonor = mysqli_fetch_assoc($run_pendonor)) {
    $data_pendonor[] = $row_pendonor;
}

$query_permohonan = "SELECT * FROM permohonan_pasien ORDER BY id DESC";
$run_permohonan = mysqli_query($db, $query_permohonan);
$data_permohonan = [];
while($row_permohonan = mysqli_fetch_assoc($run_permohonan)) {
    $data_permohonan[] = $row_permohonan;
}


echo json_encode([
    "status" => "success",
    "data" => [ 
        // Response Card
        "total_permintaan" => (int)$row_total_permintaan['total_permintaan'],
        "stok_darah" => (int)$row_total_darah['stok_darah'],
        "total_batal" => (int)$row_total_batal['total_batal'],
        "total_terpenuhi" => (int)$row_total_terpenuhi['total_terpenuhi'],
        // Response Chart
        "lokasi_pasien" => [
            "kulon_progo" => (int)$row_chart_kebutuhan_kab['kulon_progo'],
            "bantul" => (int)$row_chart_kebutuhan_kab['bantul'],
            "gunung_kidul" => (int)$row_chart_kebutuhan_kab['gunung_kidul'],
            "sleman" => (int)$row_chart_kebutuhan_kab['sleman'],
            "yogyakarta" => (int)$row_chart_kebutuhan_kab['yogyakarta'],
            "diyogyakarta" => (int)$row_chart_kebutuhan_kab['diyogyakarta']
        ],
        "golongan_darah" => [
            "A" => (int)$row_chart_tipe_darah['A'],
            "B" => (int)$row_chart_tipe_darah['B'],
            "AB" => (int)$row_chart_tipe_darah['AB'],
            "O" => (int)$row_chart_tipe_darah['O']
        ],
        "jenis_kelamin" => [
            "Lakilaki" => (int)$row_chart_jenis_kelamin['Lakilaki'],
            "Perempuan" => (int)$row_chart_jenis_kelamin['Perempuan']
        ],
        // Response Tabel
        "pendonor" => $data_pendonor,
        "permohonan" => $data_permohonan
    ]
]);
?>