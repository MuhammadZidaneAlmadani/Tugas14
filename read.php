<?php
include 'db.php';

class Mahasiswa extends Database {
    public function read() {
        $sql = "SELECT * FROM mahasiswa";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "NIM: " . $row["nim"] . " - Nama: " . $row["nama"] . " - Tempat Lahir: " . $row["tempat_lahir"] . " - Tanggal Lahir: " . $row["tanggal_lahir"] . " - Jurusan: " . $row["jurusan"] . " - Program Studi: " . $row["program_studi"] . " - IPK: " . $row["ipk"] . "<br>";
            }
        } else {
            echo "0 results";
        }
    }
}

$mahasiswa = new Mahasiswa();
$mahasiswa->read();
?>
