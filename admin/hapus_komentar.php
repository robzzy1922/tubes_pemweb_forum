<?php

require_once '../function/koneksi.php';
session_start();

// Mengganti PDO dengan mysqli
require '../function/koneksi.php';

$id_komentar = $_GET['id'];
$id_pengguna = $_SESSION['user']['id_user'];
$email_pengguna = $_SESSION['user']['email']; // Ambil email dari session

// Ambil komentar untuk memastikan komentar tersebut milik pengguna yang sedang login atau admin
$sql = $email_pengguna == 'admin@gmail.com' ? 
    "SELECT * FROM komentar WHERE id=?" : // Admin bisa mengakses semua komentar
    "SELECT * FROM komentar WHERE id=? AND id_pengguna=?"; // Pengguna biasa hanya bisa mengakses komentarnya
$stmt = mysqli_prepare($conn, $sql);
if ($email_pengguna == 'admin@gmail.com') {
    mysqli_stmt_bind_param($stmt, "i", $id_komentar);
} else {
    mysqli_stmt_bind_param($stmt, "ii", $id_komentar, $id_pengguna);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$komentar = mysqli_fetch_assoc($result);



// Proses penghapusan komentar
$sqlhapus = $email_pengguna == 'admin@gmail.com' ? 
    "DELETE FROM komentar WHERE id=?" : // Admin bisa menghapus semua komentar
    "DELETE FROM komentar WHERE id=? AND id_pengguna=?"; // Pengguna biasa hanya bisa menghapus komentarnya
$stmthapus = mysqli_prepare($conn, $sqlhapus);
if ($email_pengguna == 'admin@gmail.com') {
    mysqli_stmt_bind_param($stmthapus, "i", $id_komentar);
} else {
    mysqli_stmt_bind_param($stmthapus, "ii", $id_komentar, $id_pengguna);
}
mysqli_stmt_execute($stmthapus);

if (mysqli_stmt_affected_rows($stmthapus) > 0) {
    // Jika penghapusan berhasil, kembali ke topik
    header("Location: lihat_post.php?id=" . $komentar['id_topik']);
    exit;
} else {
    // Jika penghapusan gagal, tampilkan pesan error
    echo "Gagal menghapus komentar. Silakan coba lagi.";
}