<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $stok   = $_POST['stok'];
    $satuan = $_POST['satuan'];

    mysqli_query($koneksi, "
        INSERT INTO bahan (nama_bahan, stok, satuan)
        VALUES ('$nama', '$stok', '$satuan')
    ");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Bahan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="content">   
        <h2>Tambah Bahan</h2>

        <form method="post">
            <label>Nama Bahan</label><br>
            <input type="text" name="nama" required><br><br>

            <label>Stok</label><br>
            <input type="number" step="0.01" name="stok" required><br><br>

            <label>Satuan</label><br>
            <input type="text" name="satuan" placeholder="kg / pcs / ml" required><br><br>

            <button type="submit" name="simpan">Simpan</button>
        </form>

        <?php include "../../layout/choose.php"; ?>
    </div>
</body>
</html>
