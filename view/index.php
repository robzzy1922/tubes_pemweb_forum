<?php
require_once '../function/cek_akses.php';
require '../function/koneksi.php'; // Menggunakan require untuk memuat file koneksi.php

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT judul, tanggal, nama, email, topik.id, id_pengguna FROM topik
INNER JOIN user ON topik.id_pengguna = user.id_user";

if ($search) {
    $sql .= " WHERE judul LIKE ? OR nama LIKE ?";
}

$sql .= " ORDER BY tanggal DESC";

$query = mysqli_prepare($conn, $sql);

if ($search) {
    $search_param = '%' . $search . '%';
    mysqli_stmt_bind_param($query, 'ss', $search_param, $search_param);
}

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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FODIS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link " aria-current="page" href="tambah_post.php">Posting</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="profil.php"> Profil
                        </a>
                    </li>

                    <form class="d-flex mx-auto me-4" role="search" method="get" action="">
                        <input class=" form-control me-2" type="search" placeholder="Cari judul atau user"
                            aria-label="Search" name="search" value="<?= htmlentities($search); ?>">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h3 class="mt-3">
            <?php 
    if(isset($_SESSION['user'])){
        echo $_SESSION['user']['nama'];
    }
    ?>
            , Selamat datang di FODIS</h3>
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
                    <?php 
                    if($_SESSION['user']['id_user'] == $data['id_pengguna']){
                    ?>
                    - <a href="hapus_post.php?id=<?= $data['id']; ?>"
                        onclick="return confirm('Yakin ingin menghapus post?')" class="text-muted">Hapus</a>
                    <?php } ?>
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