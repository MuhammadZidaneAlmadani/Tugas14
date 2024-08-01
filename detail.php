<?php
include 'db.php'; // Menghubungkan ke file db.php

class Mahasiswa extends Database {
    // Fungsi untuk mendapatkan data mahasiswa berdasarkan NIM
    public function getMahasiswaByNIM($nim) {
        $stmt = $this->conn->prepare("SELECT * FROM mahasiswa WHERE nim = ?"); // Menggunakan prepared statement untuk menghindari SQL Injection
        $stmt->bind_param("i", $nim); // Mengikat parameter NIM
        $stmt->execute(); // Menjalankan query
        return $stmt->get_result()->fetch_assoc(); // Mengembalikan hasil query sebagai array asosiatif
    }
}

$mahasiswa = new Mahasiswa(); // Membuat instance dari kelas Mahasiswa
$data = null;
$message = '';

if (isset($_GET['nim'])) { // Memeriksa apakah parameter NIM ada dalam URL
    $nim = $_GET['nim']; // Mendapatkan NIM dari URL
    $data = $mahasiswa->getMahasiswaByNIM($nim); // Mendapatkan data mahasiswa berdasarkan NIM

    if (!$data) {
        $message = "Data tidak ditemukan."; // Pesan ketika data tidak ditemukan
    }
} else {
    $message = "Parameter NIM tidak ditemukan."; // Pesan ketika NIM tidak diberikan
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Detail Mahasiswa</h2>
        
        <?php if ($message): ?>
            <!-- Menampilkan pesan jika ada -->
            <div class="alert alert-warning"><?php echo $message; ?></div>
        <?php else: ?>
            <div class="card">
                <div class="card-header">
                    <h3><?php echo htmlspecialchars($data['nama']); ?></h3> <!-- Menampilkan nama mahasiswa -->
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>NIM</th>
                            <td><?php echo htmlspecialchars($data['nim']); ?></td> <!-- Menampilkan NIM -->
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td><?php echo htmlspecialchars($data['nama']); ?></td> <!-- Menampilkan nama -->
                        </tr>
                        <tr>
                            <th>Tempat Lahir</th>
                            <td><?php echo htmlspecialchars($data['tempat_lahir']); ?></td> <!-- Menampilkan tempat lahir -->
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td><?php echo htmlspecialchars($data['tanggal_lahir']); ?></td> <!-- Menampilkan tanggal lahir -->
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td><?php echo htmlspecialchars($data['jurusan']); ?></td> <!-- Menampilkan jurusan -->
                        </tr>
                        <tr>
                            <th>Program Studi</th>
                            <td><?php echo htmlspecialchars($data['program_studi']); ?></td> <!-- Menampilkan program studi -->
                        </tr>
                        <tr>
                            <th>IPK</th>
                            <td><?php echo htmlspecialchars($data['ipk']); ?></td> <!-- Menampilkan IPK -->
                        </tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Back</a> <!-- Tombol kembali ke halaman utama -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>