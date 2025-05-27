<?php
session_start();
include 'db.php';

// pastikan session start di awal file
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];  // ambil id_user dari session

// debugging: menampilkan session untuk verifikasi
// echo "Session ID: " . session_id(); 
// tampilkan session ID untuk memverifikasi
// echo "<br>User ID: " . $_SESSION['id_user']; 
// tampilkan id_user setelah login

$query = mysqli_query($conn, "SELECT * FROM bookings WHERE id_user = $id_user ORDER BY tanggal DESC");

// cek apakah ada riwayat pemesanan
if (mysqli_num_rows($query) == 0) {
    echo "<br><p class='text-center'>Belum ada riwayat pemesanan.</p>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="dark" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" width="24" height="24" class="me-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="kalender.php">Kalender</a></li>
                    <li class="nav-item"><a class="nav-link active" href="riwayat.php">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link active" href="infoAkun.php">Akun</a></li>
                    <li class="nav-item"><a class="nav-link active" href="infoBantuan.php">Bantuan</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Konten Riwayat -->
    <div class="container mt-5">
        <h2>Riwayat Booking Anda</h2>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Booking</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                while($row = mysqli_fetch_assoc($query)) : 
                    // Hanya tampilkan aksi untuk booking milik pengguna yang login
                    $isUserBooking = $row['id_user'] == $id_user;
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_booking']) ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['jam_mulai'] ?></td>
                    <td><?= $row['jam_selesai'] ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status'] == 'selesai' ? 'success' : 'warning' ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <!-- Tampilkan aksi hanya jika ini adalah booking milik pengguna yang login -->
                        <?php if ($isUserBooking): ?>
                            <a href="edit_booking.php?id=<?= $row['id_booking'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <?php if($row['status'] != 'selesai'): ?>
                                <a href="selesai_booking.php?id=<?= $row['id_booking'] ?>" class="btn btn-sm btn-success">Selesai</a>
                            <?php endif; ?>
                            <a href="hapus_booking.php?id=<?= $row['id_booking'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus booking ini?')">Hapus</a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada aksi</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
