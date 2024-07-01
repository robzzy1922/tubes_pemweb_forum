<?php
session_start();
require '../function/koneksi.php';

// Fetch user data
$sql = "SELECT * FROM user WHERE id_user=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user']['id_user']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$error = '';


if (!empty($_POST)) {
    // Validasi email harus unik
    $sqlEmail = "SELECT count(*) FROM user WHERE email=? AND id_user!=?";
    $stmtEmail = mysqli_prepare($conn, $sqlEmail);
    mysqli_stmt_bind_param($stmtEmail, "si", $_POST['email'], $_SESSION['user']['id_user']);
    mysqli_stmt_execute($stmtEmail);
    $resultEmail = mysqli_stmt_get_result($stmtEmail);
    $count = mysqli_fetch_array($resultEmail)[0];

    if ($count > 0) {
        $error = 'Email sudah digunakan, silahkan gunakan email lain!';
    } else {
        // Update user data
        $sqlUpdate = "UPDATE user SET nama=?, email=? WHERE id_user=?";
        $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ssi", $_POST['nama'], $_POST['email'], $_SESSION['user']['id_user']);
        mysqli_stmt_execute($stmtUpdate);

        // Update session
        $_SESSION['user']['nama'] = $_POST['nama'];
        $_SESSION['user']['email'] = $_POST['email'];

        if (!empty($_POST['password_lm']) && !empty($_POST['password_baru'])) {
            if (isset($user['password'])) {
                if (!password_verify($_POST['password_lm'], $user['password'])) {
                    $error = "Password lama salah";
                } else {
                    if ($_POST['password_baru'] != $_POST['password_baru2']) {
                        $error = "Password baru tidak sama";
                    } else {
                        $sqlPassword = "UPDATE user SET password=? WHERE id_user=?";
                        $stmtPassword = mysqli_prepare($conn, $sqlPassword);
                        $hashedPassword = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmtPassword, "si", $hashedPassword, $_SESSION['user']['id_user']);
                        mysqli_stmt_execute($stmtPassword);
                        echo "<script>alert('Password berhasil diubah');window.location.assign('profil.php');</script>";
                    }
                }
            } else {
                $error = "Password lama salah!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FODIS - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
include '../template/nav.php';
   ?>
    <!-- MULAI KODE -->

    <div class="container">
        <div class="row mb-3 mt-5 align-items-center">
            <div class="col-auto">
                <img src="//gravatar.com/avatar/<?= md5($user['email']); ?>?s=48&d=robohash" class="rounded-circle"
                    alt="Avatar">
            </div>
            <div class="col">
                <h2 class="mb-0"><?= htmlentities($user['nama']);?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?php
                if($error != ''){
                    echo '<p class="text-danger">'.$error.'</p>';
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="form label" id="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama"
                            value="<?= htmlentities(isset($_POST['nama']) ? $_POST['nama']:$user['nama']);?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="form label" id="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="<?= htmlentities(isset($_POST['email']) ? $_POST['email']:$user['email']);?>"
                            required>
                    </div>
                    <hr>
                    <h5>Ganti Password</h5>
                    <p class="text-info">Kosongkan jika tidak diganti</p>
                    <div class="mb-3">
                        <label for="form label" id="password_lm">Password lama</label>
                        <input type="password" class="form-control" name="password_lm" id="password_lm">
                    </div>
                    <div class="mb-3">
                        <label for="form label" id="password_baru">Password baru</label>
                        <input type="password" class="form-control" name="password_baru" id="password_baru">
                    </div>
                    <div class="mb-3">
                        <label for="form label" id="password_baru2">Ketik ulang password baru</label>
                        <input type="password" class="form-control" name="password_baru2" id="password_baru2">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>

</html>