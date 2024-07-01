<?php
require '../function/koneksi.php';

$error = '';
$hasil = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password != $password2) {
        $error = "Password dan konfirmasi password tidak sama";
    } elseif (strlen($password) < 6) {
        $error = "Password Minimal 6 Karakter";
    } elseif ($stmt = $conn->prepare("SELECT COUNT(*) as count FROM user WHERE email=?")) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result['count'] > 0) {
            $error = "Gunakan Email Lain";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            if ($stmt = $conn->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)")) {
                $stmt->bind_param("sss", $nama, $email, $passwordHash);
                $stmt->execute();
                $hasil = $stmt->affected_rows > 0;
                if (!$hasil) $error = "Registrasi gagal, coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FODIS - Daftar</title>
    <link rel="stylesheet" href="style/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="table-form w-100" style="max-width: 500px;">
            <h1 class="text-center mb-5">Buat Akun</h1>
            <?php if ($hasil) echo '<p class="text-success text-center">Registrasi Berhasil, Silahkan Log In</p>'; ?>
            <?php if ($error) echo '<p class="text-danger text-center"><i>' . $error . '</i></p>'; ?>
            <form action="" method="post">
                <ul class="list-unstyled">
                    <li class="form-floating mb-3">
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" required />
                        <label for="nama">Nama Lengkap</label>
                    </li>
                    <li class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required />
                        <label for="email">Email</label>
                    </li>
                    <li class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                            required />
                        <label for="password">Password</label>
                        <p class="text-danger fs-6 fw-light"> <i> Password harus lebih dari 6 karakter </i></p>

                    </li>
                    <li class="form-floating mb-3">
                        <input type="password" class="form-control" name="password2" id="password2"
                            placeholder="Password" required />
                        <label for="password2">Konfirmasi Password</label>
                    </li>
                    <li>
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </li>
                    <li class="text-center mt-3">
                        <p>Sudah punya akun? <a href="login.php">Log in</a></p>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</body>

</html>