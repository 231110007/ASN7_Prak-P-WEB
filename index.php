<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data KRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border-radius: 10px;
        }
        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
        .btn {
            border-radius: 20px;
            padding: 6px 16px;
        }
        .btn-sm {
            padding: 4px 10px;
            font-size: 0.85rem;
        }
        .btn-success {
            background-color: #198754;
            border: none;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #000;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .text-center h4 {
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-center">Kartu Rencana Studi Mahasiswa</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Mata Kuliah</th>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($conn, "
                        SELECT 
                            krs.id, 
                            mahasiswa.nama, 
                            mahasiswa.nim, 
                            matakuliah.nama_matkul,
                            krs.semester,
                            krs.tahun_ajaran
                        FROM krs 
                            JOIN mahasiswa ON krs.mahasiswa_id = mahasiswa.id 
                            JOIN matakuliah ON krs.matakuliah_id = matakuliah.id
                            ORDER BY krs.id DESC
                    ");
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                <td class='text-center'>{$no}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['nim']}</td>
                                <td>{$row['nama_matkul']}</td>
                                <td class='text-center'>{$row['semester']}</td>
                                <td class='text-center'>{$row['tahun_ajaran']}</td>
                                <td class='text-center'>
                                    <a href='update.php?id={$row['id']}' class='btn btn-warning btn-sm'>Update</a>
                                    <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                                </td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data KRS.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
                <div class="d-flex justify-content-center">
                <a href="add.php" class="btn btn-success">Tambah KRS</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>