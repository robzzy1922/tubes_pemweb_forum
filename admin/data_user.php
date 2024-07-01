<?php
require '../function/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    include '../template/nav_admin.php';
    // Mengambil data user dari database
    $query = "SELECT * FROM user"; // Sesuaikan dengan nama tabel dan kolom yang benar
    $result = mysqli_query($conn, $query);
    ?>
    <div class="container mt-5">
        <h2>Daftar User</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id_user'] ?></td>
                    <td><?= $row['nama'] ?></td> <!-- Sesuaikan dengan nama kolom di database -->
                    <td><?= $row['email'] ?></td> <!-- Sesuaikan dengan nama kolom di database -->
                    <td>
                        <form action="delete_user.php" method="POST">
                            <!-- Buat file ini untuk menghandle penghapusan -->
                            <input type="hidden" name="id" value="<?= $row['id_user'] ?>">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>