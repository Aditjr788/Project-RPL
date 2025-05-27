<?php
session_start();
include 'db.php';

$sukses = $error = "";

// cek apakah user sudah login
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

// proses form jika dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $nama = trim($_POST["nama"]);
    $pesan = trim($_POST["pesan"]);

    if (!empty($email) && !empty($nama) && !empty($pesan)) {
        $stmt = $conn->prepare("INSERT INTO messages (id_user, nama, email, pesan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_user, $nama, $email, $pesan);

        if ($stmt->execute()) {
            $sukses = "Pesan berhasil dikirim!";
        } else {
            $error = "Gagal mengirim pesan: " . $conn->error;
        }

        $stmt->close();
    } else {
        $error = "Semua kolom harus diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Info Bantuan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" width="30" height="30" class="me-2">
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
    
    <!-- Konten Akun -->
    <div class="container my-4">
        <h3>Informasi dan Peraturan</h3>
        <ul>
            <li>Gunakan email kampus untuk login dan daftar akun.</li>
            <li>Pilih tanggal di 'Lihat Kalender' untuk membuat jadwal booking baru.</li>
            <li>Maksimal waktu pemakaian tempat adalah 3 jam.</li>
            <li>Pembatalan dan mengganti jadwal maksimal 1 jam sebelum waktu pemakaian.</li>
            <li>Segera hapus riwayat booking, jika sudah dilaksanakan.</li>
        </ul>
    </div>
    <br>

    <div class="container my-4">
        <h5><strong>Jika ingin tanya-tanya, silakan hubungi kami dengan mengisi formulir dibawah</strong></h5>
        <br>

        <?php if (!empty($sukses)): ?>
            <div class="alert alert-success"><?= $sukses ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="infoBantuan.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" 
                    value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Pesan</label>
                <textarea class="form-control" name="pesan" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-dark">Kirim</button>
            <a href="index.php" class="btn btn-outline-secondary">Kembali</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
