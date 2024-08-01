<?php
include 'db.php'; // Menghubungkan ke file db.php

class Mahasiswa extends Database {
    public function delete($nim) {
        $stmt = $this->conn->prepare("DELETE FROM mahasiswa WHERE nim = ?"); // Query untuk menghapus data berdasarkan NIM
        $stmt->bind_param("i", $nim); // Mengikat parameter
        return $stmt->execute(); // Mengembalikan hasil eksekusi query
    }
}

$mahasiswa = new Mahasiswa();
$message = '';

if (isset($_GET['nim'])) {
    $nim = $_GET['nim']; // Mengambil NIM dari URL
    if ($mahasiswa->delete($nim)) {
        $message = "Data berhasil dihapus."; // Pesan ketika berhasil dihapus
    } else {
        $message = "Terjadi kesalahan saat menghapus data."; // Pesan ketika gagal menghapus
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Delete Mahasiswa</h2>
        <div class="alert alert-info">
            <?php echo $message; ?> <!-- Menampilkan pesan status penghapusan -->
        </div>
        <a href="index.php" class="btn btn-secondary">Back</a> <!-- Tombol kembali -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
