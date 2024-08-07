<?php
// Koneksi ke database (ganti dengan koneksi sesuai dengan konfigurasi Anda)
$servername = "localhost";
$username = "root";
$password = "galaxys23";
$dbname = "kuliner";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil id_user dari request POST atau GET
$id_user = $_GET['id_user']; // Sesuaikan dengan metode pengiriman data dari aplikasi Anda

// Query untuk mengambil total_panen dan pendapatan dari tabel saldo berdasarkan id_user
$sql = "SELECT SUM(total_panen) AS total_panen, SUM(pendapatan) AS pendapatan
        FROM saldo
        WHERE id_user = $id_user";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil hasil query
    $row = $result->fetch_assoc();
    
    // Format hasil ke dalam bentuk array
    $saldo = array(
        'total_panen' => floatval($row['total_panen']),
        'pendapatan' => floatval($row['pendapatan'])
    );
    
    // Konversi ke format JSON dan kirimkan respons
    header('Content-Type: application/json');
    echo json_encode($saldo);
} else {
    echo "Tidak ada data saldo yang ditemukan untuk id_user = $id_user";
}

$conn->close();
?>
