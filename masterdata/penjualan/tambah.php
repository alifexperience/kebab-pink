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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            min-height: 100vh;
        }

        .content {
            padding: 20px;
        }

        /* ===== SIDEBAR DESKTOP ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100vh;
            background: #ff4d6d;
            color: #fff;
            padding-top: 20px;
        }

        .sidebar .logo {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
            font-size: 20px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
        }

        /* ===== CONTENT ===== */
        .pos-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 25px;
            margin-top: 10px;
        }

        /* Header Page */
        .page-header {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-left: 5px solid #ff4d6d;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header h1 {
            font-size: 28px;
            color: #2d3748;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 i {
            color: #ff4d6d;
        }

        .transaction-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #666;
            font-size: 14px;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 10px;
        }

        .transaction-info i {
            color: #ff4d6d;
        }

        .menu-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h3 {
            font-size: 20px;
            color: #2d3748;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header h3 i {
            color: #ff4d6d;
        }

        .menu-count {
            background: #ff4d6d;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 20px;
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .menu-grid::-webkit-scrollbar {
            width: 6px;
        }

        .menu-grid::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .menu-grid::-webkit-scrollbar-thumb {
            background: #ff4d6d;
            border-radius: 10px;
        }

        .menu-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #f0f0f0;
            position: relative;
            overflow: hidden;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            border-color: #ff4d6d;
            box-shadow: 0 10px 25px rgba(255, 77, 109, 0.15);
        }

        .menu-icon {
            font-size: 36px;
            margin-bottom: 12px;
            color: #ff4d6d;
            height: 70px;
            width: 70px;
            background: rgba(255, 77, 109, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
        }

        .menu-name {
            font-size: 15px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-price {
            font-size: 18px;
            font-weight: 700;
            color: #ff4d6d;
            margin-bottom: 15px;
        }

        .add-btn {
            background: #ff4d6d;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .add-btn:hover {
            background: #ff3359;
            transform: translateY(-2px);
        }

        .cart-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            max-height: 700px;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
        }

        .cart-items::-webkit-scrollbar {
            width: 6px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: #ff4d6d;
            border-radius: 10px;
        }

        .cart-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid #ff4d6d;
        }

        .cart-item:hover {
            background: #f0f2f5;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .item-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 15px;
        }

        .remove-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .remove-btn:hover {
            background: #dc2626;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            border-radius: 8px;
            padding: 6px 10px;
            border: 1px solid #e2e8f0;
        }

        .qty-btn {
            background: #ff4d6d;
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .qty-btn:hover {
            background: #ff3359;
        }

        .qty-display {
            min-width: 35px;
            text-align: center;
            font-weight: 700;
            color: #2d3748;
            font-size: 15px;
        }

        .item-subtotal {
            font-weight: 700;
            color: #ff4d6d;
            font-size: 16px;
        }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }

        .empty-cart i {
            font-size: 70px;
            margin-bottom: 15px;
            color: #e2e8f0;
        }

        .empty-cart p {
            font-size: 16px;
            color: #94a3b8;
        }

        .cart-summary {
            border-top: 2px solid #e2e8f0;
            padding-top: 25px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #fff5f7 0%, #ffeef1 100%);
            border-radius: 12px;
            border: 2px solid #ffeef1;
        }

        .total-amount {
            color: #ff4d6d;
        }

        .payment-input-group {
            margin-bottom: 20px;
        }

        .payment-input-group label {
            display: block;
            margin-bottom: 10px;
            color: #4a5568;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .payment-input-group label i {
            color: #ff4d6d;
        }

        .payment-input-group input {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }

        .payment-input-group input:focus {
            outline: none;
            border-color: #ff4d6d;
            box-shadow: 0 0 0 3px rgba(255, 77, 109, 0.1);
            background: white;
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #ff4d6d 0%, #ff758f 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(255, 77, 109, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 77, 109, 0.4);
        }

        .submit-btn:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .submit-btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Clear Cart Button */
        .clear-cart-btn {
            width: 100%;
            padding: 12px;
            background: #f8f9fa;
            color: #666;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .clear-cart-btn:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        /* ===== MOBILE MODE ===== */
        @media (max-width: 768px) {
            body {
                padding-left: 0;
                padding-bottom: 60px;
            }

            .content {
                padding-left: 0;
                padding-right: 15px;
                padding-top: 15px;
                padding-bottom: 80px;
            }

            .sidebar {
                width: 100%;
                height: 60px;
                position: fixed;
                bottom: 0;
                top: auto;
                display: flex;
                justify-content: space-around;
                align-items: center;
                padding: 0;
            }

            .sidebar .logo {
                display: none;
            }

            .sidebar a {
                padding: 5px;
                font-size: 12px;
                text-align: center;
            }

            .sidebar a span {
                display: none;
            }

            .pos-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding: 20px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .transaction-info {
                width: 100%;
                justify-content: center;
            }

            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }

            .cart-section {
                max-height: 500px;
            }

            .total-row {
                font-size: 20px;
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu-card {
                padding: 15px;
            }

            .menu-icon {
                font-size: 28px;
                height: 50px;
                width: 50px;
            }

            .menu-name {
                font-size: 13px;
                height: 35px;
            }

            .menu-price {
                font-size: 15px;
            }

            .add-btn {
                padding: 8px 15px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-cash-register"></i>
                Point of Sale - Kasir
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