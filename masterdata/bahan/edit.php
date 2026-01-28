<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM bahan WHERE id_bahan='$id'");
$bahan = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $stok   = $_POST['stok'];
    $satuan = $_POST['satuan'];

    mysqli_query($koneksi, "
        UPDATE bahan 
        SET nama_bahan='$nama', stok='$stok', satuan='$satuan'
        WHERE id_bahan='$id'
    ");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Bahan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="content">
        <h2>Edit Bahan</h2>

        <form method="post">
            <label>Nama Bahan</label><br>
            <input type="text" name="nama" value="<?= $bahan['nama_bahan'] ?>" required><br><br>

            <label>Stok</label><br>
            <input type="number" step="0.01" name="stok" value="<?= $bahan['stok'] ?>" required><br><br>

            <label>Satuan</label><br>
            <input type="text" name="satuan" value="<?= $bahan['satuan'] ?>" required><br><br>

            <button type="submit" name="update">Update</button>
        </form>

        <?php include "../../layout/choose.php"; ?>
    </div>
</body>
</html>
