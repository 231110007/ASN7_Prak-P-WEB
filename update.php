<?php 
include 'connection.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}
$id = intval($_GET['id']);
$query = "
    SELECT 
        krs.*, 
        mahasiswa.nama AS nama_mahasiswa, mahasiswa.nim,
        matakuliah.nama_matkul 
    FROM krs
        JOIN mahasiswa ON krs.mahasiswa_id = mahasiswa.id
        JOIN matakuliah ON krs.matakuliah_id = matakuliah.id
        WHERE krs.id = $id";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    die("Data tidak ditemukan.");
}
$data = mysqli_fetch_assoc($result);
?>

<?php
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_mahasiswa']);
    $nim  = mysqli_real_escape_string($conn, $_POST['nim']);
    $matkul = mysqli_real_escape_string($conn, $_POST['nama_matkul']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun_ajaran']);
    $updateMhs = mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama', nim='$nim' WHERE id = {$data['mahasiswa_id']}");
    $updateMk = mysqli_query($conn, "UPDATE matakuliah SET nama_matkul='$matkul' WHERE id = {$data['matakuliah_id']}");
    $updateKrs = mysqli_query($conn, "
        UPDATE krs 
        SET semester = '$semester', tahun_ajaran = '$tahun'
        WHERE id = $id
    ");
    if ($updateMhs && $updateMk && $updateKrs) {
        echo "<script>alert('Data berhasil diupdate.'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal update: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Data KRS</title>
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
            <h4>Update Data KRS</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" class="form-control" value="<?= htmlspecialchars($data['nama_mahasiswa']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($data['nim']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Mata Kuliah</label>
                    <input type="text" name="nama_matkul" class="form-control" value="<?= htmlspecialchars($data['nama_matkul']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <input type="text" name="semester" class="form-control" value="<?= htmlspecialchars($data['semester']) ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" class="form-control" value="<?= htmlspecialchars($data['tahun_ajaran']) ?>" required>
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="submit" name="update" class="btn btn-success">Update</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>