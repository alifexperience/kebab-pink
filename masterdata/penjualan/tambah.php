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
    <title>Kasir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
    <div class="content">
        <h3>Pilih menu</h3>
        <?php while ($m = mysqli_fetch_assoc($menu)) : ?>
        <div style="border:1px solid #ccc;padding:10px;margin:5px;display:inline-block">
            <b><?= $m['nama_menu'] ?></b><br>
            Rp<?= number_format($m['harga']) ?><br>
            <a href="?add=<?= $m['id_menu'] ?>">Tambah</a>
        </div>
        <?php endwhile; ?>

        <hr>

        <h3>Keranjang</h3>
        <form method="post" action="simpan.php">

        <table border="1" cellpadding="5">
        <tr>
            <th>Menu</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($_SESSION['cart'] as $id_menu => $qty): 
            $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$id_menu'");
            $m = mysqli_fetch_assoc($q);
            $sub = $m['harga'] * $qty;
        ?>
        <tr>
            <td><?= $m['nama_menu'] ?></td>
            <td><?= $qty ?></td>
            <td>Rp<?= number_format($sub) ?></td>
        </tr>
        <?php endforeach; ?>
        </table>

        <br>
        <b>Total : Rp<?= number_format($total) ?></b><br><br>

        <label>Uang Dibayar</label><br>
        <input type="number" name="bayar" required><br><br>

        <input type="hidden" name="total" value="<?= $total ?>">

        <button type="submit" name="simpan">Simpan Penjualan</button>
        </form>

        <?php include "../../layout/choose.php"; ?>
    </div>
</body>
</html>
