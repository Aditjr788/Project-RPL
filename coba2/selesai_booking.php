<?php
include 'db.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Persiapkan query
$stmt = $conn->prepare("UPDATE bookings SET status = 'selesai' WHERE id_booking = ?");
$stmt->bind_param("i", $id);  // "i" menunjukkan bahwa $id adalah integer

// Jalankan query
if ($stmt->execute()) {
    // Redirect setelah update berhasil
    header("Location: riwayat.php");
} else {
    // Jika ada error, tampilkan pesan error
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
