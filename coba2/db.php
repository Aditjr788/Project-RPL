<?php
// db.php - Koneksi ke database

$host = "localhost";
$user = "root";        // sesuaikan dengan username MySQL
$password = "";        // sesuaikan dengan password MySQL
$database = "booking_tempat";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>