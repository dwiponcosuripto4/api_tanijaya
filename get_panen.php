<?php
// Sambungkan ke database
$connect = new mysqli("localhost", "root", "galaxys23", "kuliner", 3306);

// Set header Content-Type JSON
header('Content-Type: application/json');

// Periksa koneksi
if ($connect->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connection failed: " . $connect->connect_error)));
}

// Ambil id_lahan dari request (misalnya dari query string)
$idLahan = isset($_GET['id_lahan']) ? intval($_GET['id_lahan']) : 0;

// Periksa apakah id_lahan valid
if ($idLahan > 0) {
    // Ambil data dari tabel 'panen' berdasarkan id_lahan
    $sql = "SELECT * FROM panen WHERE id_lahan = ?";
    $stmt = $connect->prepare($sql);
    if ($stmt === false) {
        die(json_encode(array("status" => "error", "message" => "Failed to prepare statement: " . $connect->error)));
    }
    
    $stmt->bind_param("i", $idLahan);
    $stmt->execute();
    $result = $stmt->get_result();

    // untuk menyimpan data
    $data = array();

    // Periksa query dieksekusi
    if ($result->num_rows > 0) {
        // Output data setiap baris
        while ($row = $result->fetch_assoc()) {
            // Tambahkan data ke dalam array
            $data[] = $row;
        }
        // Encode data menjadi format JSON 
        echo json_encode($data);
    } else {
        echo json_encode(array("status" => "error", "message" => "Tidak ada data panen yang ditemukan untuk id_lahan: $idLahan"));
    }

    // Tutup statement
    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid id_lahan"));
}

// Tutup koneksi
$connect->close();
?>
