<?php
include 'db.php'; // Menghubungkan ke file db.php

class Mahasiswa extends Database {
    public function getMahasiswaByNIM($nim) {
        $stmt = $this->conn->prepare("SELECT * FROM mahasiswa WHERE nim = ?"); // Query untuk mengambil data berdasarkan NIM
        $stmt->bind_param("i", $nim); // Mengikat parameter
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // Mengembalikan data sebagai array asosiatif
    }

    public function update($nim, $nama, $tempat_lahir, $tanggal_lahir, $jurusan, $program_studi, $ipk) {
        $stmt = $this->conn->prepare("UPDATE mahasiswa SET nama = ?, tempat_lahir = ?, tanggal_lahir = ?, jurusan = ?, program_studi = ?, ipk = ? WHERE nim = ?");
        $stmt->bind_param("sssssdi", $nama, $tempat_lahir, $tanggal_lahir, $jurusan, $program_studi, $ipk, $nim); // Mengikat parameter
        if ($stmt->execute()) {
            return true; // Mengembalikan true jika update berhasil
        } else {
            return false; // Mengembalikan false jika update gagal
        }
    }
}

$mahasiswa = new Mahasiswa();
$message = ''; // Pesan untuk status operasi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim']; // Mengambil data NIM dari POST
    $nama = $_POST['nama']; // Mengambil data Nama dari POST
    $tempat_lahir = $_POST['tempat_lahir']; // Mengambil data Tempat Lahir dari POST
    $tanggal_lahir = $_POST['tanggal_lahir']; // Mengambil data Tanggal Lahir dari POST
    $jurusan = $_POST['jurusan']; // Mengambil data Jurusan dari POST
    $program_studi = $_POST['program_studi']; // Mengambil data Program Studi dari POST
    $ipk = $_POST['ipk']; // Mengambil data IPK dari POST

    if ($mahasiswa->update($nim, $nama, $tempat_lahir, $tanggal_lahir, $jurusan, $program_studi, $ipk)) {
        $message = "Data berhasil diubah."; // Pesan ketika berhasil diubah
    } else {
        $message = "Terjadi kesalahan saat mengubah data."; // Pesan ketika gagal mengubah
    }
}

if (isset($_GET['nim'])) {
    $nim = $_GET['nim']; // Mengambil NIM dari URL
    $data = $mahasiswa->getMahasiswaByNIM($nim); // Mendapatkan data mahasiswa berdasarkan NIM
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Update Mahasiswa</h2>
        <?php if ($message) : ?>
            <div class="alert alert-info"><?php echo $message; ?></div> <!-- Menampilkan pesan -->
        <?php endif; ?>
        <?php if ($data) : ?>
            <form method="POST" action="update.php">
                <input type="hidden" name="nim" value="<?php echo htmlspecialchars($data['nim']); ?>"> <!-- Menyimpan NIM sebagai input tersembunyi -->
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Jurusan</label>
                    <input type="text" name="jurusan" class="form-control" value="<?php echo htmlspecialchars($data['jurusan']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Program Studi</label>
                    <input type="text" name="program_studi" class="form-control" value="<?php echo htmlspecialchars($data['program_studi']); ?>" required>
                </div>
                <div class="form-group">
                    <label>IPK</label>
                    <input type="number" step="0.01" name="ipk" class="form-control" value="<?php echo htmlspecialchars($data['ipk']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </form>
        <?php else : ?>
            <p>Data tidak ditemukan.</p> <!-- Pesan ketika data tidak ditemukan -->
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
