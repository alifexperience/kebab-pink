<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$menu = mysqli_query($koneksi, "SELECT * FROM menu");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// hitung total awal
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
    <?php include "../../layout/style-penjualan.php"; ?>
</head>

<body>
    <div class="content">

        <!-- HEADER -->
        <div class="page-header">
            <h1><i class="fas fa-chart-line"></i> Penjualan</h1>
            <div class="transaction-info">
                <div><i class="fas fa-calendar-day"></i> <?= date('d F Y') ?></div>
                <div><i class="fas fa-clock"></i> <?= date('H:i') ?></div>
                <div><i class="fas fa-shopping-cart"></i> <?= count($_SESSION['cart']) ?> item</div>
            </div>
        </div>

        <div class="pos-container">

            <!-- MENU -->
            <div class="menu-section">
                <div class="section-header">
                    <h3><i class="fas fa-utensils"></i> Daftar Menu</h3>
                    <span class="menu-count"><?= mysqli_num_rows($menu) ?> Menu</span>
                </div>

                <div class="menu-grid">
                    <?php while ($m = mysqli_fetch_assoc($menu)) : ?>
                        <div class="menu-card">
                            <div class="menu-name"><?= htmlspecialchars($m['nama_menu']) ?></div>
                            <div class="menu-price">Rp <?= number_format($m['harga'], 0, ',', '.') ?></div>
                            <button class="add-btn"
                                onclick="cartAction('add', <?= $m['id_menu'] ?>)">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- CART -->
            <div class="cart-section">
                <div class="section-header">
                    <h3><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h3>
                </div>

                <div class="cart-items">
                    <!-- diisi via AJAX -->
                </div>

                <div class="cart-summary">
                    <div class="total-row">
                        <span>Total Pembayaran</span>
                        <span class="total-amount">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>

                    <form method="post" action="simpan.php">
                        <input type="hidden" name="total" id="totalInput" value="<?= $total ?>">

                        <div class="payment-input-group">
                            <label>
                                <i class="fas fa-money-bill-wave"></i> Uang Dibayar
                            </label>
                            <input type="number"
                                name="bayar"
                                id="bayar"
                                required
                                min="<?= $total ?>"
                                placeholder="Uang dibayar">
                        </div>

                        <div class="payment-input-group">
                            <label>
                                <i class="fas fa-exchange-alt"></i> Kembalian
                            </label>
                            <input type="text" id="kembalian" readonly value="Rp 0">
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-check-circle"></i> Proses Pembayaran
                        </button>
                    </form>

                </div>
            </div>
        </div>
        <?php include "../../layout/choose.php"; ?>
    </div>

    <!-- ================= AJAX SCRIPT ================= -->
    <script>
        function cartAction(action, id) {
            fetch('cart_action.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=${action}&id=${id}`
                })
                .then(res => res.json())
                .then(data => renderCart(data));
        }

        function renderCart(data) {
            const cartBox = document.querySelector('.cart-items');
            const totalEl = document.querySelector('.total-amount');
            const totalInput = document.getElementById('totalInput');
            const countEl = document.querySelector('.fa-shopping-cart').parentElement;

            countEl.innerHTML = `<i class="fas fa-shopping-cart"></i> ${data.count} item`;
            totalEl.textContent = `Rp ${data.total}`;
            totalInput.value = data.raw_total;

            if (data.items.length === 0) {
                cartBox.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-shopping-basket"></i>
                <p>Keranjang masih kosong</p>
            </div>`;
                return;
            }

            cartBox.innerHTML = '';

            data.items.forEach(item => {
                cartBox.innerHTML += `
        <div class="cart-item">
            <div class="item-header">
                <span class="item-name">${item.nama}</span>
                <button class="remove-btn"
                    onclick="cartAction('remove', ${item.id})">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            <div class="item-footer">
                <div class="qty-control">
                    <button class="qty-btn"
                        onclick="cartAction('decrease', ${item.id})">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="qty-display">${item.qty}</span>
                    <button class="qty-btn"
                        onclick="cartAction('add', ${item.id})">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <span class="item-subtotal">Rp ${item.subtotal}</span>
            </div>
        </div>`;
            });
        }

        // load cart saat halaman dibuka
        cartAction('load', 0);

        const bayarInput = document.getElementById('bayar');
        const totalInput = document.getElementById('totalInput');
        const kembalianInput = document.getElementById('kembalian');

        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        function hitungKembalian() {
            const bayar = parseInt(bayarInput.value || 0);
            const total = parseInt(totalInput.value || 0);
            const kembali = bayar - total;

            kembalianInput.value = kembali >= 0 ?
                formatRupiah(kembali) :
                'Rp 0';
        }

        bayarInput.addEventListener('input', hitungKembalian);
    </script>

</body>

</html>