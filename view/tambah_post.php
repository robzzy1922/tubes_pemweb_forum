<?php
require_once '../function/cek_akses.php';

if(!empty($_POST)){
    
    require '../function/koneksi.php'; // Menggunakan require untuk memuat file koneksi.php
    // Menyiapkan query SQL
    $sql = "INSERT INTO topik (judul, deskripsi, tanggal, id_pengguna) VALUES (?, ?, NOW(), ?)";
    
    // Mempersiapkan statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Mengikat parameter ke statement
    mysqli_stmt_bind_param($stmt, "ssi", $_POST['judul'], $_POST['deskripsi'], $_SESSION['user']["id_user"]);
    
    // Menjalankan statement
    mysqli_stmt_execute($stmt);
    
    // Mengarahkan ulang ke halaman tambah_topik.php dengan parameter sukses
    header("Location: tambah_post.php?sukses=1");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FODIS - Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .text-warning {
        text-shadow: 2px 1px 1px #000000;

    }
    </style>
</head>

<body>
    <?php 
include '../template/nav.php';
   ?>

    <div class="container">
        <?php 
        if(isset($_GET['sukses']) && $_GET['sukses'] == '1'){
echo '<p class="text-success">Postingan berhasil terkirim</p>';
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label" for="judul" id="judul">Judul</label>
                        <input type="text" name="judul" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="deskripsi" id="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
        <div class="peringatan mt-5">
            <h4 class="text-warning">Rules Dalam Postingan :</h4>
            <ul class="list-unstyled">
                <li class="mb-1 text-secondary">Pastikan judul postingan jelas dan spesifik.</li>
                <li class="mb-1 text-secondary">Gunakan bahasa yang sopan dan hindari ujaran kebencian.</li>
                <li class="mb-1 text-secondary">Jangan memposting hal-hal berbau pornografi dan narkotika.</li>
                <li class="mb-1 text-secondary">Jaga privasi pribadi dan orang lain, jangan membagikan informasi
                    sensitif.</li>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>