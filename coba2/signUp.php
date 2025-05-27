<?php
include 'db.php'; // koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $password_raw = $_POST['password'] ?? '';

    if (empty($nama) || empty($email) || empty($password_raw)) {
        echo "Nama, Email, dan Password wajib diisi.";
        exit;
    }

    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Role otomatis isi default 'lainnya'
    $role = 'lainnya';

    $sql = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $nama, $email, $password, $role);

        if ($stmt->execute()) {
            echo "Berhasil daftar!";
        } else {
            echo "Gagal daftar: " . $stmt->error;
        }
    } else {
        echo "Query error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css?v=2" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-2">Booking Tempat</h2>
                <p class="text-center"><em>-Belakang Gedung Opon-</em></p>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php elseif (!empty($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="custom-btn btn btn-light w-100">DAFTAR</button>
                </form>
                <p class="mt-3 text-center">Kembali login? <a href="login.php">Iya!</a></p>
            </div>
        </div>
    </div>
</body>
</html>