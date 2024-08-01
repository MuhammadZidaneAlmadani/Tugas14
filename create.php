<?php
include 'db.php'; // Menghubungkan ke file db.php

class Mahasiswa extends Database {
    // Fungsi untuk menambahkan data mahasiswa
    public function create($nim, $nama, $tempat_lahir, $tanggal_lahir, $jurusan, $program_studi, $ipk) {
        // Query untuk memasukkan data mahasiswa baru
        $stmt = $this->conn->prepare("INSERT INTO mahasiswa (nim, nama, tempat_lahir, tanggal_lahir, jurusan, program_studi, ipk) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssd", $nim, $nama, $tempat_lahir, $tanggal_lahir, $jurusan, $program_studi, $ipk); // Mengikat parameter
        return $stmt->execute(); // Menjalankan query
    }
}

$mahasiswa = new Mahasiswa();
$success = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa dan memvalidasi input
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jurusan = $_POST['jurusan'];
    $program_studi = $_POST['program_studi'];
    $ipk = $_POST['ipk'];

    // Validasi input
    if (!is_numeric($nim) || strlen($nim) !== 10) {
        $error = "NIM harus berupa 10 digit angka.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $error = "Nama hanya boleh mengandung huruf dan spasi.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $tempat_lahir)) {
        $error = "Tempat Lahir hanya boleh mengandung huruf dan spasi.";
    } elseif (!validateDate($tanggal_lahir)) {
        $error = "Tanggal Lahir harus dalam format yyyy-mm-dd.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $jurusan)) {
        $error = "Jurusan hanya boleh mengandung huruf dan spasi.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $program_studi)) {
        $error = "Program Studi hanya boleh mengandung huruf dan spasi.";
    } elseif (!is_numeric($ipk)) {
        $error = "IPK harus berupa angka antara 0 dan 4.";
    } else {
        // Memasukkan data ke database
        $success = $mahasiswa->create($nim, $nama, $tempat_lahir, $tanggal_lahir, $jurusan, $program_studi, $ipk);
    }
}

// Fungsi untuk memvalidasi tanggal
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Tambah Mahasiswa Baru</h2>

        <?php if ($success): ?>
            <div class="alert alert-success">Data mahasiswa berhasil ditambahkan.</div> <!-- Pesan ketika berhasil menambah data -->
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div> <!-- Pesan kesalahan -->
        <?php endif; ?>

        <form method="POST" action="create.php">
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" required pattern="\d{10}" title="NIM harus berupa 10 digit angka"> <!-- Validasi input NIM -->
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required pattern="[a-zA-Z\s]+" title="Nama hanya boleh mengandung huruf dan spasi"> <!-- Validasi input nama -->
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" required pattern="[a-zA-Z\s]+" title="Tempat Lahir hanya boleh mengandung huruf dan spasi"> <!-- Validasi input tempat lahir -->
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" required> <!-- Validasi input tanggal lahir -->
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" class="form-control" required pattern="[a-zA-Z\s]+" title="Jurusan hanya boleh mengandung huruf dan spasi"> <!-- Validasi input jurusan -->
            </div>
            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" name="program_studi" class="form-control" required pattern="[a-zA-Z\s]+" title="Program Studi hanya boleh mengandung huruf dan spasi"> <!-- Validasi input program studi -->
            </div>
            <div class="form-group">
                <label>IPK</label>
                <input type="number" step="0.01" name="ipk" class="form-control" min="0" max="4" required> <!-- Validasi input IPK -->
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="index.php" class="btn btn-secondary">Back</a> <!-- Tombol kembali ke halaman utama -->
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
