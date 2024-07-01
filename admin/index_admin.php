<?php
require_once '../function/cek_akses.php';
require '../function/koneksi.php'; // Menggunakan require untuk memuat file koneksi.php

$sql = "SELECT judul, tanggal, nama, email, topik.id, id_pengguna FROM topik
INNER JOIN user ON topik.id_pengguna = user.id_user ORDER BY tanggal DESC";

$query = mysqli_prepare($conn, $sql);

mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FODIS - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    include '../template/nav_admin.php';
    ?>
    <div class="container">
        <h3 class="mt-3">
            <?php 
    if(isset($_SESSION['user'])){
        echo $_SESSION['user']['nama'];
    }
    ?>
            , Selamat datang di FODIS - Admin</h3>
        <?php 
if (isset($_SESSION['user'])) {
?>
        <h5 class="mt-5">Daftar Topik</h5>
        <hr>
        <?php 
        while ($data = mysqli_fetch_assoc($result)){?>
        <div class="row">
            <div class="col-auto">
                <img src="//gravatar.com/avatar/<?= md5($data['email']); ?>?s=48&d=robohash" class="rounded-circle"
                    alt="Avatar">
            </div>

            <figure class="col">
                <blockquote class="blockquote">
                    <p>
                        <a href="lihat_post.php?id=<?= $data['id']; ?>"><?= htmlentities($data['judul']); ?></a>
                    </p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    Dari: <?= ($data['nama']); ?>
                    - <?= date('d M Y H:i', strtotime($data['tanggal'])); ?>
                    - <a href="../admin/hapus_post.php?id=<?= $data['id']; ?>"
                        onclick="return confirm('Yakin ingin menghapus post?')" class="text-muted">Hapus</a>
                </figcaption>
            </figure>
        </div>
        <?php }?>
        <?php }?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>