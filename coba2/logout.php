<?php
session_start();

// Menghapus semua variabel session
$_SESSION = array();

// Jika menggunakan session cookies, hapus juga cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session
session_destroy();

header("Location: login.php");
exit;
?>
