<?php
require '../function/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Mendapatkan ID dari form

    // Query untuk menghapus komentar terkait
    $query_komentar = "DELETE FROM komentar WHERE id_pengguna = ?";
    $stmt_komentar = mysqli_prepare($conn, $query_komentar);
    mysqli_stmt_bind_param($stmt_komentar, 'i', $id);
    mysqli_stmt_execute($stmt_komentar);

    // Query untuk menghapus user
    $query_user = "DELETE FROM user WHERE id_user = ?";
    $stmt_user = mysqli_prepare($conn, $query_user);
    mysqli_stmt_bind_param($stmt_user, 'i', $id);
    mysqli_stmt_execute($stmt_user);
    
    if (mysqli_stmt_affected_rows($stmt_user) > 0) {
        header('Location: data_user.php'); // Kembali ke halaman daftar user
    } else {
        echo "Gagal menghapus user.";
    }
}