<?php
session_start();
require_once "../../koneksi/koneksi.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? '';
$id     = $_POST['id'] ?? '';

if ($action !== 'load' && $id) {
    switch ($action) {
        case 'add':
            $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
            break;

        case 'decrease':
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]--;
                if ($_SESSION['cart'][$id] <= 0) {
                    unset($_SESSION['cart'][$id]);
                }
            }
            break;

        case 'remove':
            unset($_SESSION['cart'][$id]);
            break;
    }
}

$items = [];
$total = 0;

foreach ($_SESSION['cart'] as $id_menu => $qty) {
    $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$id_menu'");
    $m = mysqli_fetch_assoc($q);

    $sub = $m['harga'] * $qty;
    $total += $sub;

    $items[] = [
        'id' => $id_menu,
        'nama' => $m['nama_menu'],
        'qty' => $qty,
        'subtotal' => number_format($sub, 0, ',', '.')
    ];
}

echo json_encode([
    'items' => $items,
    'total' => number_format($total, 0, ',', '.'),
    'raw_total' => $total,
    'count' => count($_SESSION['cart'])
]);
