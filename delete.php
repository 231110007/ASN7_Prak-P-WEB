<?php
include 'connection.php';
// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location='index.php';</script>";
    exit;
}
$krs_id = intval($_GET['id']);
// Ambil data mahasiswa_id dan matakuliah_id dari krs
$result = mysqli_query($conn, "SELECT mahasiswa_id, matakuliah_id FROM krs WHERE id = $krs_id");
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data KRS tidak ditemukan.'); window.location='index.php';</script>";
    exit;
}

$row = mysqli_fetch_assoc($result);
$mahasiswa_id = $row['mahasiswa_id'];
$matakuliah_id = $row['matakuliah_id'];

// Hapus dari tabel krs
$delete_krs = mysqli_query($conn, "DELETE FROM krs WHERE id = $krs_id");
// Hapus dari tabel mahasiswa
$delete_mhs = mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $mahasiswa_id");
// Hapus dari tabel matakuliah
$delete_mk = mysqli_query($conn, "DELETE FROM matakuliah WHERE id = $matakuliah_id");
if ($delete_krs && $delete_mhs && $delete_mk) {
    echo "<script>alert('Data KRS, Mahasiswa, dan Mata Kuliah berhasil dihapus.'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data: " . mysqli_error($conn) . "'); window.location='index.php';</script>";
}
?>