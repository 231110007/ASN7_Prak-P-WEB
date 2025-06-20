<?php include 'connection.php'; ?>
<?php
if (isset($_POST['submit'])) {
    $namaBaru     = mysqli_real_escape_string($conn, $_POST['nama_baru']);
    $nimBaru      = mysqli_real_escape_string($conn, $_POST['nim_baru']);
    $matkulBaru   = mysqli_real_escape_string($conn, $_POST['matkul_baru']);
    $semester     = mysqli_real_escape_string($conn, $_POST['semester']);
    $tahunAjaran  = mysqli_real_escape_string($conn, $_POST['tahun_ajaran']);
    $insertMhs = mysqli_query($conn, "INSERT INTO mahasiswa (nama, nim) VALUES ('$namaBaru', '$nimBaru')");
    if (!$insertMhs) {
        die("Gagal insert mahasiswa: " . mysqli_error($conn));
    }
    $mhsID = mysqli_insert_id($conn);
    $insertMk = mysqli_query($conn, "INSERT INTO matakuliah (nama_matkul) VALUES ('$matkulBaru')");
    if (!$insertMk) {
        die("Gagal insert matkul: " . mysqli_error($conn));
    }
    $mkID = mysqli_insert_id($conn);
    $insertKrs = mysqli_query($conn, "
        INSERT INTO krs (mahasiswa_id, matakuliah_id, semester, tahun_ajaran)
        VALUES ($mhsID, $mkID, '$semester', '$tahunAjaran')
    ");
    if ($insertKrs) {
        echo "<script>alert('Data berhasil ditambahkan ke KRS.'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal tambah ke KRS: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Add Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: none;
        }
        .card-header {
            background: linear-gradient(to right, #0d6efd, #0b5ed7);
            color: white;
            padding: 1rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card-header h4 {
            margin: 0;
            font-weight: bold;
        }
        .card-body {
            padding: 2rem;
        }
        label {
            font-weight: 500;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn {
            border-radius: 20px;
            padding: 6px 16px;
            font-weight: 500;
        }
        .btn-success {
            background-color: #198754;
            border: none;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Mahasiswa - Mata Kuliah</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <!-- Input Mahasiswa -->
                <div class="mb-3">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="nama_baru" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim_baru" class="form-control" required>
                </div>
                <!-- Input Mata Kuliah -->
                <div class="mb-3">
                    <label>Nama Mata Kuliah</label>
                    <input type="text" name="matkul_baru" class="form-control" required>
                </div>
                <!-- Semester dan Tahun Ajaran -->
                <div class="mb-3">
                    <label>Semester</label>
                    <input type="text" name="semester" class="form-control" placeholder="Contoh: Genap" required>
                </div>
                <div class="mb-4">
                    <label>Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" class="form-control" placeholder="Contoh: 2024/2025" required>
                </div>
                <!-- Tombol -->
                <div class="d-flex justify-content-center gap-2">
                    <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>