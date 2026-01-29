<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$menu = mysqli_query($koneksi, "SELECT * FROM menu");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// tambah menu ke cart
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header("Location: tambah.php");
    exit;
}

// hapus item dari cart
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: tambah.php");
    exit;
}

// kurangi qty
if (isset($_GET['decrease'])) {
    $id = $_GET['decrease'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: tambah.php");
    exit;
}

// hitung total
$total = 0;
foreach ($_SESSION['cart'] as $id_menu => $qty) {
    $q = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id_menu='$id_menu'");
    $m = mysqli_fetch_assoc($q);
    $total += $m['harga'] * $qty;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kasir - Point of Sale</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "../../layout/style-penjualan.php";?>
</head>
<body>
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-chart-line"></i>
                Penjualan 
            </h1>
            <div class="transaction-info">
                <div>
                    <i class="fas fa-calendar-day"></i>
                    <?= date('d F Y') ?>
                </div>
                <div>
                    <i class="fas fa-clock"></i>
                    <?= date('H:i') ?>
                </div>
                <div>
                    <i class="fas fa-shopping-cart"></i>
                    <?= count($_SESSION['cart']) ?> item
                </div>
            </div>
        </div>

        <div class="pos-container">
            <!-- Menu Section -->
            <div class="menu-section">
                <div class="section-header">
                    <h3>
                        <i class="fas fa-utensils"></i>
                        Daftar Menu
                    </h3>
                    <span class="menu-count">
                        <?= mysqli_num_rows($menu) ?> Menu
                    </span>
                </div>
                <div class="menu-grid">
                    <?php 
                    $icons = [
                        'fa-hamburger', 'fa-pizza-slice', 'fa-hotdog', 'fa-ice-cream', 
                        'fa-mug-hot', 'fa-cookie', 'fa-cake-candles', 'fa-martini-glass',
                        'fa-drumstick-bite', 'fa-fish', 'fa-cheese', 'fa-bread-slice'
                    ];
                    $i = 0;
                    while ($m = mysqli_fetch_assoc($menu)) : 
                        $icon = $icons[$i % count($icons)];
                        $i++;
                    ?>
                    <div class="menu-card">
                        <div class="menu-icon">
                            <i class="fas <?= $icon ?>"></i>
                        </div>
                        <div class="menu-name"><?= htmlspecialchars($m['nama_menu']) ?></div>
                        <div class="menu-price">Rp <?= number_format($m['harga'], 0, ',', '.') ?></div>
                        <a href="?add=<?= $m['id_menu'] ?>" style="text-decoration: none;">
                            <button class="add-btn">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="cart-section">
                <div class="section-header">
                    <h3>
                        <i class="fas fa-shopping-cart"></i>
                        Keranjang Belanja
                    </h3>
                    <?php if (!empty($_SESSION['cart'])): ?>
                    <a href="?clear=true" style="text-decoration: none;">
                        <button class="clear-cart-btn">
                            <i class="fas fa-trash"></i> Kosongkan
                        </button>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="cart-items">
                    <?php if (empty($_SESSION['cart'])): ?>
                        <div class="empty-cart">
                            <i class="fas fa-shopping-basket"></i>
                            <p>Keranjang masih kosong</p>
                            <p style="font-size: 14px; margin-top: 10px; color: #94a3b8;">
                                Pilih menu dari daftar untuk memulai transaksi
                            </p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($_SESSION['cart'] as $id_menu => $qty): 
                            $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$id_menu'");
                            $m = mysqli_fetch_assoc($q);
                            $sub = $m['harga'] * $qty;
                        ?>
                        <div class="cart-item">
                            <div class="item-header">
                                <span class="item-name"><?= htmlspecialchars($m['nama_menu']) ?></span>
                                <a href="?remove=<?= $id_menu ?>" style="text-decoration: none;">
                                    <button class="remove-btn">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </a>
                            </div>
                            <div class="item-footer">
                                <div class="qty-control">
                                    <a href="?decrease=<?= $id_menu ?>" style="text-decoration: none;">
                                        <button class="qty-btn">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </a>
                                    <span class="qty-display"><?= $qty ?></span>
                                    <a href="?add=<?= $id_menu ?>" style="text-decoration: none;">
                                        <button class="qty-btn">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                                <span class="item-subtotal">Rp <?= number_format($sub, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="cart-summary">
                    <div class="total-row">
                        <span>Total Pembayaran</span>
                        <span class="total-amount">Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>

                    <form method="post" action="simpan.php">
                        <div class="payment-input-group">
                            <label>
                                <i class="fas fa-money-bill-wave"></i> Uang Dibayar
                            </label>
                            <input type="number" name="bayar" required placeholder="Masukkan jumlah uang" min="<?= $total ?>" value="<?= $total ?>">
                        </div>

                        <input type="hidden" name="total" value="<?= $total ?>">

                        <button type="submit" name="simpan" class="submit-btn" <?= empty($_SESSION['cart']) ? 'disabled' : '' ?>>
                            <i class="fas fa-check-circle"></i>
                            Proses Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php include "../../layout/choose.php"; ?>
    </div>

    <script>
        // Auto update time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            const timeElement = document.querySelector('.transaction-info .fa-clock').parentElement;
            if (timeElement) {
                timeElement.innerHTML = `<i class="fas fa-clock"></i> ${timeString}`;
            }
        }

        // Update time every minute
        updateTime();
        setInterval(updateTime, 60000);

        // Update item count
        function updateCartCount() {
            const cartItems = <?= json_encode($_SESSION['cart'] ?? []) ?>;
            const itemCount = Object.keys(cartItems).length;
            const countElement = document.querySelector('.transaction-info .fa-shopping-cart').parentElement;
            if (countElement) {
                countElement.innerHTML = `<i class="fas fa-shopping-cart"></i> ${itemCount} item`;
            }
        }

        // Auto focus on payment input when cart not empty
        document.addEventListener('DOMContentLoaded', function() {
            const cartItems = <?= json_encode($_SESSION['cart'] ?? []) ?>;
            if (Object.keys(cartItems).length > 0) {
                const paymentInput = document.querySelector('input[name="bayar"]');
                if (paymentInput) {
                    paymentInput.focus();
                    paymentInput.select();
                }
            }
        });

        // Add subtle animation to menu cards
        document.querySelectorAll('.menu-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('.add-btn')) {
                    const addBtn = this.querySelector('.add-btn');
                    if (addBtn) {
                        addBtn.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            addBtn.style.transform = '';
                        }, 300);
                    }
                }
            });
        });

        // Clear cart confirmation
        document.querySelector('.clear-cart-btn')?.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>