<?php

require_once '../function/koneksi.php'; //koneksi
session_start();

// Mengganti PDO dengan mysqli
require '../function/koneksi.php';

if (!isset($_GET['id']) || !isset($_SESSION['user']['id_user'])) {
    // Pastikan ID komentar dan ID pengguna tersedia
    header("Location: index.php");
    exit;
}

$id_komentar = $_GET['id'];
$id_pengguna = $_SESSION['user']['id_user'];

// Ambil komentar untuk memastikan komentar tersebut milik pengguna yang sedang login
$sql = "SELECT * FROM komentar WHERE id=? AND id_pengguna=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_komentar, $id_pengguna);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$komentar = mysqli_fetch_assoc($result);

if (!$komentar) {
    // Jika komentar tidak ditemukan atau bukan milik pengguna, redirect
    header("Location: index.php");
    exit;
}

// Proses penghapusan komentar
$sqlhapus = "DELETE FROM komentar WHERE id=? AND id_pengguna=?";
$stmthapus = mysqli_prepare($conn, $sqlhapus);
mysqli_stmt_bind_param($stmthapus, "ii", $id_komentar, $id_pengguna);
mysqli_stmt_execute($stmthapus);

if (mysqli_stmt_affected_rows($stmthapus) > 0) {
    // Jika penghapusan berhasil, kembali ke topik
    header("Location: lihat_post.php?id=" . $komentar['id_topik']);
    exit;
} else {
    // Jika penghapusan gagal, tampilkan pesan error
    echo "Gagal menghapus komentar. Silakan coba lagi.";
}