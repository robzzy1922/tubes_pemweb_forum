<?php
session_start(); // Memindahkan session_start() ke bagian atas sebelum output apapun
require '../function/koneksi.php'; // Menggunakan koneksi dari koneksi.php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FODIS - Lihat Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    include '../template/nav.php';
    ?>
    <!-- KODE DIMULAI -->
    <div class="container">
        <?php
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "SELECT topik.*, user.nama, user.email FROM topik 
            INNER JOIN user ON topik.id_pengguna=user.id_user
            WHERE topik.id='$id'";
            $result = mysqli_query($conn, $sql);
            $topik = mysqli_fetch_assoc($result);
            if(empty($topik)){
                echo '<p class="text-warning">Postingan tidak ditemukan!</p>';
            } else {
                ?>
        <!-- mulai kode -->
        <div class="row mb-3">
            <div class="col-auto">
                <img src="//gravatar.com/avatar/<?= md5($topik['email']); ?>?s=48&d=robohash" class="rounded-circle"
                    alt="Avatar">
            </div>
            <div class="col">
                <div class="fw-bold"><?= ($topik['nama']);?></div>
                <small class="text-muted">
                    <?= date('d M Y H:i', strtotime($topik['tanggal'])); ?>
                </small>
            </div>
        </div>
        <h2><?= htmlentities($topik['judul']);?></h2>
        <p><?= nl2br(htmlentities($topik['deskripsi']));?></p>
        <hr>
        <?php
                $sql2 = "SELECT komentar.*, user.nama, user.email FROM komentar
                INNER JOIN user ON user.id_user = komentar.id_pengguna
                WHERE id_topik='$id'";
                $result2 = mysqli_query($conn, $sql2);
                while($komentar = mysqli_fetch_assoc($result2)){
                    ?>
        <div class="row">
            <div class="col-auto">
                <img src="//gravatar.com/avatar/<?= md5($komentar['email']); ?>?s=48&d=robohash" class="rounded-circle"
                    alt="Avatar">
            </div>
            <div class="col mb-4 ">
                <div class="bg-light py-2 px-3 rounded">
                    <div class="row gx-2">
                        <div class="col">
                            <?= ($komentar['nama']);?>
                        </div>
                        <?php 
                                    if($_SESSION['user']['id_user'] == $komentar['id_pengguna']){?>
                        <div class="col-auto">
                            <a href="hapus_komentar.php?id=<?= $komentar['id'] ;?>"
                                onclick="return confirm('Yakin ingin menghapus komentar?')"
                                class="text-muted"><small>Hapus</small>
                            </a>
                        </div>
                        <?php } ?>
                        <div class="col-auto">
                            <small><?= date('d M Y H:i', strtotime($komentar['tanggal'])); ?></small>
                        </div>
                        <div class="mt-3">
                            <?= nl2br(htmlentities($komentar['komentar']));?>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <?php }?>
        <hr>
        <div class="row">
            <div class="col-auto">
                <?php
                            // Debug: Periksa isi dari $_SESSION['user']
                            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
                                echo '<p class="text-danger">Email pengguna tidak tersedia!</p>';
                            } else {
                                // Jika email tersedia, lanjutkan dengan menampilkan avatar
                                $emailHash = md5($_SESSION['user']['email']);
                                ?>
                <img src="//gravatar.com/avatar/<?= $emailHash; ?>?s=48&d=robohash" class="rounded-circle" alt="Avatar">
                <?php
                            }
                            ?>
            </div>
            <div class="col">
                <form action="jawab_post.php" method="post">
                    <div class="mb-3">
                        <textarea class="form-control" name="komentar" id="komentar" placeholder="Komentar"></textarea>
                        <input type="hidden" value="<?= $topik['id'] ;?>" name="id_topik">
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
                }
            }
        
        ?>
    </div>


</body>

</html>