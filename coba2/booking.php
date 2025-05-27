<?php
session_start();
include 'db.php';

// cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$tanggal_terpilih = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

// ambil jadwal yang sudah dibooking pada tanggal tertentu
$query = "SELECT * FROM bookings WHERE tanggal = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $tanggal_terpilih);
$stmt->execute();
$result = $stmt->get_result();

$jadwal = [];
while ($row = $result->fetch_assoc()) {
    $jadwal[] = $row;
}

// proses penyimpanan booking baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';
    $jam_mulai = $_POST['jam_mulai'] ?? '';
    $jam_selesai = $_POST['jam_selesai'] ?? '';
    $id_user = $_SESSION['id_user']; // ambil dari session

    $status = 'aktif';
    $stmt = $conn->prepare("INSERT INTO bookings (id_user, nama_booking, tanggal, jam_mulai, jam_selesai, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id_user, $nama, $tanggal, $jam_mulai, $jam_selesai, $status);


    if ($stmt->execute()) {
        echo "<script>alert('Pemesanan berhasil'); window.location.href='booking.php?tanggal=$tanggal';</script>";
    } else {
        echo "<script>alert('Gagal membuat pemesanan');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pemesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Konten Utama -->
    <div class="container my-4">
        <?php if ($tanggal_terpilih): ?>
            <h3 class="mb-4">Jadwal yang terisi pada tanggal <?= htmlspecialchars($tanggal_terpilih) ?></h3>
        <?php else: ?>
            <h3 class="mb-4">Jadwal yang terisi</h3>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($jadwal) > 0): ?>
                    <?php foreach ($jadwal as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama_booking']) ?></td>
                            <td><?= htmlspecialchars($item['jam_mulai']) ?></td>
                            <td><?= htmlspecialchars($item['jam_selesai']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada pemesanan untuk tanggal ini</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br>

        <h4>Pemesanan Baru</h4>
        <form action="booking.php?tanggal=<?= htmlspecialchars($tanggal_terpilih) ?>" method="post">
            <input type="hidden" name="tanggal" value="<?= htmlspecialchars($tanggal_terpilih) ?>">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" required>
            </div>
            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" id="jam_mulai" required>
            </div>
            <div class="mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control" id="jam_selesai" required>
            </div>
            <button type="submit" class="btn btn-dark">Buat</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
