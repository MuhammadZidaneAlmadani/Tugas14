<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>Data Mahasiswa</h2>
            <a href="create.php" class="btn btn-success">Add Mahasiswa</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Jurusan</th>
                    <th>Program Studi</th>
                    <th>IPK</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Fetching data from database -->
                <?php
                include 'db.php';

                class Mahasiswa extends Database {
                    public function read() {
                        $sql = "SELECT * FROM mahasiswa";
                        $result = $this->conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["nim"] . "</td>";
                                echo "<td>" . $row["nama"] . "</td>";
                                echo "<td>" . $row["tempat_lahir"] . "</td>";
                                echo "<td>" . $row["tanggal_lahir"] . "</td>";
                                echo "<td>" . $row["jurusan"] . "</td>";
                                echo "<td>" . $row["program_studi"] . "</td>";
                                echo "<td>" . $row["ipk"] . "</td>";
                                echo "<td>";
                                echo "<a href='detail.php?nim=" . $row["nim"] . "' class='btn btn-info btn-sm'>Detail</a> ";
                                echo "<a href='update.php?nim=" . $row["nim"] . "' class='btn btn-warning btn-sm'>Ubah</a> ";
                                echo "<a href='delete.php?nim=" . $row["nim"] . "' class='btn btn-danger btn-sm'>Hapus</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No data found</td></tr>";
                        }
                    }
                }

                $mahasiswa = new Mahasiswa();
                $mahasiswa->read();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
