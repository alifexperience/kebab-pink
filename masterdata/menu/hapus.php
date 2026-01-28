<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$id = $_GET['id'];

// hapus resep dulu
$hapusResep = mysqli_query($koneksi, "
    DELETE FROM menu_bahan WHERE id_menu = '$id'
");

if ($hapusResep) {

    // hapus menu
    mysqli_query($koneksi, "
        DELETE FROM menu WHERE id_menu = '$id'
    ");

    header("Location: index.php");
    exit;

} else {
    echo "Gagal menghapus menu";
}
