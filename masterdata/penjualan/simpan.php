<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

if (empty($_SESSION['cart'])) {
    header("Location: tambah.php");
    exit;
}

$total = $_POST['total'];
$bayar = $_POST['bayar'];

if ($bayar < $total) {
    echo "Uang bayar kurang!";
    exit;
}

$kembalian = $bayar - $total;

// simpan penjualan
$simpan = mysqli_query($koneksi, "
    INSERT INTO penjualan (tanggal, total, bayar, kembalian)
    VALUES (NOW(), '$total', '$bayar', '$kembalian')
");

if (!$simpan) {
    echo "Gagal simpan penjualan";
    exit;
}

$id_penjualan = mysqli_insert_id($koneksi);

// detail + potong stok
foreach ($_SESSION['cart'] as $id_menu => $qty) {

    mysqli_query($koneksi, "
        INSERT INTO detail_penjualan (id_penjualan, id_menu, qty, harga)
        SELECT '$id_penjualan', id_menu, '$qty', harga
        FROM menu WHERE id_menu='$id_menu'
    ");

    $resep = mysqli_query($koneksi, "
        SELECT * FROM menu_bahan WHERE id_menu='$id_menu'
    ");

    while ($r = mysqli_fetch_assoc($resep)) {
        $kurang = $r['jumlah'] * $qty;
        mysqli_query($koneksi, "
            UPDATE bahan
            SET stok = stok - $kurang
            WHERE id_bahan='{$r['id_bahan']}'
        ");
    }
}

unset($_SESSION['cart']);

echo "
<h2>Penjualan Berhasil</h2>
Total : Rp" . number_format($total) . "<br>
Bayar : Rp" . number_format($bayar) . "<br>
<b>Kembalian : Rp" . number_format($kembalian) . "</b><br><br>
<a href='tambah.php'>Penjualan Baru</a>
";
