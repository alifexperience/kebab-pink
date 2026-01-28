<?php
require_once "../../koneksi/koneksi.php";

$id = $_GET['id'];

$q = mysqli_query($koneksi, "
    SELECT b.nama_bahan, mb.jumlah, b.satuan
    FROM menu_bahan mb
    JOIN bahan b ON mb.id_bahan = b.id_bahan
    WHERE mb.id_menu = '$id'
");

if (mysqli_num_rows($q) == 0) {
    echo "<p>Resep belum diatur</p>";
}

while ($r = mysqli_fetch_assoc($q)) {
    $jumlah = rtrim(rtrim($r['jumlah'], '0'), '.');
    echo $r['nama_bahan'] ." " . $jumlah . " " . $r['satuan'] . "<br>";
}
