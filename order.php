<?php
// Konfigurasi koneksi database
$servername = "localhost"; // atau IP server database
$username = "root"; // ganti dengan username database Anda
$password = ""; // ganti dengan password database Anda
$dbname = "techdeveloper";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memproses form jika data dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $details = $_POST['details'];

    // Mengupload file referensi desain jika ada
    $file_name = "";
    if (!empty($_FILES['fileToUpload']['name'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $file_name;

        // Validasi ekstensi file
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (in_array($fileType, ["doc", "docx", "pdf"])) {
            // Upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "File " . htmlspecialchars($file_name) . " berhasil diupload.";
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file.";
            }
        } else {
            echo "Hanya file DOC, DOCX, dan PDF yang diperbolehkan.";
            exit;
        }
    }

    // Menyimpan data ke tabel user
    $sql = "INSERT INTO user (name, phone, email, status, details, file_name) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $phone, $email, $status, $details, $file_name);

    if ($stmt->execute()) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>