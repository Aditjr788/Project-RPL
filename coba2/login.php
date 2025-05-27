<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_user, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // password benar, buat session
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            // debugging: menampilkan session untuk verifikasi
            echo 'Session ID: ' . session_id();  // tampilkan session ID untuk memverifikasi
            echo '<br>User ID: ' . $_SESSION['id_user'];  // tampilkan id_user setelah login

            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="custom-btn btn btn-light w-100">MASUK</button>
                </form>
                <p class="mt-3 text-center">Belum punya akun? <a href="signUp.php">Daftar</a></p>
            </div>
        </div>
    </div>
</body>
</html>
