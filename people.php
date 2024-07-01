<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "galaxys23"; // Your MySQL password
$dbname = "kuliner"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $foto = $_FILES['gambar']['name'];

    // Upload directory
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);

    // Upload file
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO people (nama, email, alamat, no_telepon, foto) VALUES ('$nama', '$email', '$alamat', '$no_telepon', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            $response = array("message" => "New record created successfully");
        } else {
            $response = array("message" => "Error: " . $sql . "<br>" . $conn->error);
        }
    } else {
        $response = array("message" => "Sorry, there was an error uploading your file.");
    }

    echo json_encode($response);
    $conn->close();
} else {
    echo json_encode(array("message" => "Invalid request method"));
}
?>
