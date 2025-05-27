<?php
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

if ($month < 1) {
    $month = 12;
    $year--;
} elseif ($month > 12) {
    $month = 1;
    $year++;
}

$monthName = date('F', mktime(0, 0, 0, $month, 1, $year));

function buildCalendar($month, $year) {
    $html = "";
    $dayCounter = 1;
    $startDay = date('w', mktime(0, 0, 0, $month, 1, $year));
    $daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));

    // Baris pertama
    $html .= "<tr>";
    for ($i = 0; $i < $startDay; $i++) {
        $html .= "<td class='text-muted'></td>";
    }

    for ($i = $startDay; $i < 7; $i++) {
        $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($dayCounter, 2, '0', STR_PAD_LEFT);
        $html .= "<td><a href='booking.php?tanggal=$date'>$dayCounter</a></td>";
        $dayCounter++;
    }
    $html .= "</tr>";

    // baris berikutnya
    while ($dayCounter <= $daysInMonth) {
        $html .= "<tr>";
        for ($i = 0; $i < 7; $i++) {
            if ($dayCounter > $daysInMonth) {
                $html .= "<td class='text-muted'></td>";
            } else {
                $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($dayCounter, 2, '0', STR_PAD_LEFT);
                $html .= "<td><a href='booking.php?tanggal=$date'>$dayCounter</a></td>";
                $dayCounter++;
            }
        }
        $html .= "</tr>";
    }

    return $html;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a.nav-arrow, a.nav-arrow:visited {
        color: black !important;
        text-decoration: none !important;
        }
    </style>

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
    <div class="full-page">
        <div class="calendar">
            <div class="calendar-header">
                <a href="?month=<?= $month - 1 ?>&year=<?= $year ?>" class="nav-arrow">&lt;</a>
                <h2><?= $monthName . ' ' . $year ?></h2>
                <a href="?month=<?= $month + 1 ?>&year=<?= $year ?>" class="nav-arrow">&gt;</a>
            </div>
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>Min</th><th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th>
                    </tr>
                </thead>
                <tbody>
                    <?= buildCalendar($month, $year) ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
