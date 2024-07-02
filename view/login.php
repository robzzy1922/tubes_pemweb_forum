<?php
session_start();
$hasil = true;

if (!empty($_POST)) {
    require '../function/koneksi.php';  // Memuat koneksi database
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (!$user) {
        $hasil = false;
    } elseif (!password_verify($_POST['password'], $user['password'])) {
        $hasil = false;
    } else {
        $hasil = true;
        $_SESSION['user'] = [
            'id_user' => $user['id_user'],
            'nama' => $user['nama'],
            'email' => $user['email'],
        ];
        
        if ($_POST['email'] == "admin@gmail.com" && $_POST['password'] == "123456"){
            header("Location: ../admin/index_admin.php");
        }else{
            header("Location: ../view/index.php");
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FODIS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="table-form w-100" style="max-width: 500px;">
            <h1 class="text-center mb-5">Login</h1>
            <?php 
            if(!$hasil){
                echo "<p class='text-danger text-center'>Password atau Email Salah</p>";
            }
            ?>
            <form action="" method="post">
                <ul class="list-unstyled">
                    <li class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required />
                        <label for="email">Email</label>
                    </li>
                    <li class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                            required />
                        <label for="password">Password</label>
                    </li>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <li class="text-center mt-3">
                        <p>Belum punya akun? <a href="daftar.php">Daftar</a></p>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</body>

</html>