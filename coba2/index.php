<?php
session_start();

// cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="dark" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </a>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container full-page">
        <div class="text-center">
            <h1 class="mb-4">
                Halo! 
                <small class="text-muted">Selamat datang</small>
            </h1>
        <div class="button-group d-flex flex-column align-items-center gap-3">
            <a href="kalender.php" class="btn btn-dark custom-btn">LIHAT KALENDER</a>
            <a href="riwayat.php" class="btn btn-dark custom-btn">LIHAT RIWAYAT PEMESANAN</a>
            <a href="infoAkun.php" class="btn btn-dark custom-btn">INFO AKUN</a>
            <a href="infoBantuan.php" class="btn btn-dark custom-btn">INFO BANTUAN</a>
        </div>
    </div>
</body>
</html>