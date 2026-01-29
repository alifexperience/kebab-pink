<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$id = $_GET['id'];

// hapus detail dulu
$hapusDetail = mysqli_query($koneksi, "
    DELETE FROM detail_penjualan WHERE id_penjualan = '$id'
");

if ($hapusDetail) {
    mysqli_query($koneksi, "
        DELETE FROM penjualan WHERE id_penjualan = '$id'
    ");

    header("Location: index.php");
    exit;
} else {
    echo "Gagal hapus penjualan";
}
