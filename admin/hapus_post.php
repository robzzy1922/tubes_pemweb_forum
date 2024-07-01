<?php
require_once '../function/koneksi.php'; // 
session_start();

if (!isset($_GET['id']) || !isset($_SESSION['user']['id_user'])) {
    // Pastikan ID komentar dan ID pengguna tersedia
    header("Location: ../view/index.php");
    exit;
}

// Cek apakah pengguna adalah admin
if ($_SESSION['user']['email'] == "admin@gmail.com") {
    // Jika admin, hapus semua topik dan komentar tanpa memeriksa kepemilikan
    $sqlDeleteAllComments = "DELETE FROM komentar WHERE id_topik=?";
    $stmtDeleteAllComments = $conn->prepare($sqlDeleteAllComments);
    $stmtDeleteAllComments->bind_param("i", $_GET['id']);
    $stmtDeleteAllComments->execute();

    $sqlDeleteAllTopics = "DELETE FROM topik WHERE id=?";
    $stmtDeleteAllTopics = $conn->prepare($sqlDeleteAllTopics);
    $stmtDeleteAllTopics->bind_param("i", $_GET['id']);
    $stmtDeleteAllTopics->execute();
} 

header("Location: ../admin/index_admin.php");
exit;