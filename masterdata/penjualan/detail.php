<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$id = $_GET['id'];

// ambil data penjualan
$qPenjualan = mysqli_query($koneksi, "
    SELECT * FROM penjualan
    WHERE id_penjualan = '$id'
");

$penjualan = mysqli_fetch_assoc($qPenjualan);

if (!$penjualan) {
    echo "Data penjualan tidak ditemukan";
    exit;
}

// ambil detail menu
$detail = mysqli_query($koneksi, "
    SELECT d.qty, d.harga, m.nama_menu
    FROM detail_penjualan d
    JOIN menu m ON d.id_menu = m.id_menu
    WHERE d.id_penjualan = '$id'
");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Penjualan #<?= $id ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php include "../../layout/style-input.php"; ?>
    <style>
        .informasi {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .informasi {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Semua baris */
        .informasi ul {
            list-style: none;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            padding: 10px 14px;
            margin: 0;
            align-items: center;
            border-radius: 6px;
        }

        /* Header */
        .informasi .header-row {
            background: #f1f3f5;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }

        /* Data */
        .informasi .data-row {
            background: #ffffff;
            border-bottom: 1px solid #eee;
        }

        /* Harga & subtotal rata kanan */
        .informasi li:nth-child(2),
        .informasi li:nth-child(3) {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="content">
        <div class="header">
            <div>
                <h2><i class="fas fa-receipt"></i> Detail Penjualan</h2>
                <div class="invoice-number">TRX<?= str_pad($id, 6, '0', STR_PAD_LEFT) ?></div>
            </div>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <div class="informasi">
            <ul class="header-row">
                <li>Nama Menu</li>
                <li>Harga</li>
                <li>Subtotal</li>
            </ul>
            <?php while ($d = mysqli_fetch_assoc($detail)) : $sub = $d['qty'] * $d['harga'];?>
                <ul class="data-row">
                    <li><?= htmlspecialchars($d['nama_menu']) ?> <?= $d['qty'] ?>x</li>
                    <li>Rp<?= number_format($d['harga'], 0, ',', '.') ?></li>
                    <li><strong>Rp<?= number_format($sub, 0, ',', '.') ?></strong></li>
                </ul>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        // Smooth scroll animation
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to info cards
            const cards = document.querySelectorAll('.info-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.style.animation = 'slideDown 0.5s ease-out backwards';
            });
        });

        // Print function with loading
        function printInvoice() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="loading"></span> Menyiapkan...';
            btn.disabled = true;

            setTimeout(() => {
                window.print();
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 500);
        }

        // Download PDF placeholder
        function downloadPDF() {
            alert('Fitur download PDF akan segera tersedia!\n\nSaat ini Anda bisa menggunakan fitur Print dan pilih "Save as PDF"');
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + P untuk print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }

            // ESC untuk kembali
            if (e.key === 'Escape') {
                window.location.href = 'index.php';
            }
        });
    </script>

    <?php include "../../layout/choose.php"; ?>
</body>

</html>