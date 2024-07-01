<?php 
require_once '../function/cek_akses.php';

// Redirect jika POST kosong
if(empty($_POST)){
    header("Location: index.php");
    exit;
}

// Redirect jika id_topik tidak ada atau kosong
if(!isset($_POST['id_topik']) || empty($_POST['id_topik'])){
    header("Location: index.php");
    exit;
}

// Include koneksi database
require '../function/koneksi.php';

// SQL untuk memasukkan data
$sql = "INSERT INTO komentar (komentar, tanggal, id_topik, id_pengguna)
VALUES (?, NOW(), ?, ?)";

// Persiapan query
$query = $conn->prepare($sql);

// Binding parameter
$query->bind_param("sii", $_POST['komentar'], $_POST['id_topik'], $_SESSION['user']['id_user']);

// Eksekusi query
$query->execute();

// Redirect ke halaman topik
header("Location: lihat_post.php?id=" . $_POST['id_topik']);
exit;