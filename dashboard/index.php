<?php
require_once "../koneksi/koneksi.php";
require_once "../middleware/auth.php";

/* ====== STATISTIK ====== */
$totalPenjualan = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT SUM(total) total FROM penjualan")
)['total'] ?? 0;

$totalMenu = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) total FROM menu")
)['total'] ?? 0;

$totalBahan = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) total FROM bahan")
)['total'] ?? 0;

$today = date('Y-m-d');
$penjualanHariIni = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT SUM(total) total FROM penjualan WHERE DATE(tanggal)='$today'")
)['total'] ?? 0;

$bahanRendah = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) total FROM bahan WHERE stok < 30")
)['total'] ?? 0;

/* ====== DATA ====== */
$menuTerlaris = mysqli_query($koneksi, "
    SELECT m.nama_menu, COUNT(*) jumlah
    FROM detail_penjualan d
    JOIN menu m ON d.id_menu = m.id_menu
    GROUP BY d.id_menu
    ORDER BY jumlah DESC
    LIMIT 5
");

$recentSales = mysqli_query(
    $koneksi,
    "SELECT * FROM penjualan ORDER BY tanggal DESC LIMIT 5"
);

$lowStockItems = mysqli_query(
    $koneksi,
    "SELECT * FROM bahan WHERE stok < 30 ORDER BY stok ASC LIMIT 5"
);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kebab App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "../layout/style-dashboard.php"; ?>
</head>

<body>
    <div class="content">

        <!-- HEADER -->
        <div class="dashboard-header">
            <h2><i class="fas fa-home"></i> Dashboard</h2>
            <p>Selamat datang di Kebab App</p>
            <div class="date-display">
                <i class="far fa-calendar"></i> <?= date('l, d F Y') ?>
            </div>
        </div>

        <!-- WELCOME -->
        <div class="welcome-banner">
            <div>
                <h3>Halo, Admin!</h3>
                <p>Ringkasan performa toko hari ini</p>
            </div>
            <i class="fas fa-utensils"></i>
        </div>

        <!-- ALERT -->
        <?php if ($bahanRendah > 0): ?>
            <div class="table-card" style="border-left:4px solid #ff9800;margin-bottom:30px">
                <b>⚠ Stok Rendah</b><br>
                <?= $bahanRendah ?> bahan perlu restock
            </div>
        <?php endif; ?>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon sales"><i class="fas fa-money-bill-wave"></i></div>
                <div class="stat-info">
                    <h3>Rp <?= number_format($totalPenjualan, 0, ',', '.') ?></h3>
                    <p>Total Penjualan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon today"><i class="fas fa-sun"></i></div>
                <div class="stat-info">
                    <h3>Rp <?= number_format($penjualanHariIni, 0, ',', '.') ?></h3>
                    <p>Hari Ini</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon menuu"><i class="fas fa-hamburger"></i></div>
                <div class="stat-info">
                    <h3><?= $totalMenu ?></h3>
                    <p>Total Menu</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bahan"><i class="fas fa-carrot"></i></div>
                <div class="stat-info">
                    <h3><?= $totalBahan ?></h3>
                    <p>Total Bahan</p>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="tables-container">
            <div class="table-card">
                <h3><i class="fa-solid fa-trophy"></i> Menu Terlaris</h3>
                <table class="mini-table">
                    <?php while ($m = mysqli_fetch_assoc($menuTerlaris)): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['nama_menu']) ?></td>
                            <td><?= $m['jumlah'] ?></td>
                            <td><span class="badge normal">Populer</span></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <div class="table-card">
                <h3><i class="fa-regular fa-clock"></i> Penjualan Terbaru</h3>
                <table class="mini-table">
                    <?php while ($p = mysqli_fetch_assoc($recentSales)): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                            <td>Rp <?= number_format($p['total'], 0, ',', '.') ?></td>
                            <td><span class="badge normal">Lunas</span></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>

        <?php include "../layout/choose.php"; ?>
    </div>
</body>
</html>