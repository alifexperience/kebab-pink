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
<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <title>Penjualan Berhasil</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: rgba(0,0,0,0.5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal {
            background: #fff;
            width: 380px;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            text-align: center;
            animation: zoomIn .3s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal h2 {
            color: #28a745;
            margin-bottom: 10px;
        }

        .modal .icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 10px;
        }

        .detail {
            margin: 20px 0;
            text-align: left;
        }

        .detail div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .total {
            font-weight: bold;
            border-top: 1px dashed #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: .2s;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class='modal'>
    <div class='icon'>✅</div>
    <h2>Penjualan Berhasil</h2>

    <div class='detail'>
        <div>
            <span>Total</span>
            <span>Rp " . number_format($total) . "</span>
        </div>
        <div>
            <span>Bayar</span>
            <span>Rp " . number_format($bayar) . "</span>
        </div>
        <div class='total'>
            <span>Kembalian</span>
            <span>Rp " . number_format($kembalian) . "</span>
        </div>
    </div>

    <a href='index.php' class='btn'>Back</a>
</div>

</body>
</html>
";

