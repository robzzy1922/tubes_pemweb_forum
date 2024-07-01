<?php
require_once '../function/koneksi.php'; // 
session_start();

if (!isset($_GET['id']) || !isset($_SESSION['user']['id_user'])) {
    // Pastikan ID komentar dan ID pengguna tersedia
    header("Location: ../view/index.php");
    exit;
}

$sql = "SELECT * FROM topik WHERE id=? AND id_pengguna=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $_GET['id'], $_SESSION['user']['id_user']);
$stmt->execute();
$result = $stmt->get_result();
$topik = $result->fetch_assoc();

if(!$topik){
    // Jika topik tidak ditemukan atau bukan milik pengguna, redirect
    header("Location: ../view/index.php");
    exit;
}


$sqlDeleteComments = "DELETE FROM komentar WHERE id_topik=?";
$stmtDeleteComments = $conn->prepare($sqlDeleteComments);
$stmtDeleteComments->bind_param("i", $_GET['id']);
$stmtDeleteComments->execute();


$sqlHapus = "DELETE FROM topik WHERE id=? AND id_pengguna=?";
$queryHapus = $conn->prepare($sqlHapus);
$queryHapus->bind_param("ii", $_GET['id'], $_SESSION['user']['id_user']);
$queryHapus->execute();

header("Location: ../view/index.php");
exit;