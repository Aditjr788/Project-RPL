<?php
include 'db.php';
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_booking = $_POST['nama_booking'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Update query untuk menyertakan jam mulai dan jam selesai
    mysqli_query($conn, "UPDATE bookings SET nama_booking = '$nama_booking', tanggal = '$tanggal', jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai' WHERE id_booking = $id");
    header("Location: riwayat.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM bookings WHERE id_booking = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Booking</h2>
    <form method="post">
        <div class="mb-3">
            <label for="nama_booking" class="form-label">Nama Booking</label>
            <input type="text" name="nama_booking" class="form-control" value="<?= htmlspecialchars($data['nama_booking']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" value="<?= $data['jam_mulai'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="jam_selesai" class="form-label">Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" value="<?= $data['jam_selesai'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="riwayat.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
