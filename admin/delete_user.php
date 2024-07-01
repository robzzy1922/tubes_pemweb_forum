<?php
require '../function/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Mendapatkan ID dari form

    // Query untuk menghapus user
    $query = "DELETE FROM user WHERE id_user = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header('Location: data_user.php'); // Kembali ke halaman daftar user
    } else {
        echo "Gagal menghapus user.";
    }
}