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
    <title>Tambah Bahan | Kebab App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../../layout/style-input.php";?>

</head>

<body>
    <div class="content">
        <div class="header">
            <h2><i class="fas fa-carrot"></i> Tambah Bahan</h2>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <form method="post">
            <div class="form-group">
                <label>Nama Bahan</label>
                <input type="text" name="nama" placeholder="sosis..." required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" step="0.01" name="stok" placeholder="10..." required>
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="satuan" placeholder="pcs..." required>
                </div>
            </div>

            <button type="submit" name="simpan">Simpan</button>
        </form>

        <?php include "../../layout/choose.php"; ?>
    </div>
</body>

</html>