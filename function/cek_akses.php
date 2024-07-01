<?php
session_start();
// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika tidak, arahkan ke halaman login
    header("Location: login.php");
    exit;
}