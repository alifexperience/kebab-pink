<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

/* =========================
   AMBIL DATA BERDASARKAN ID
   ========================= */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM bahan WHERE id_bahan = '$id'");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit;
}

/* =========================
   PROSES UPDATE
   ========================= */
if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $stok   = $_POST['stok'];
    $satuan = $_POST['satuan'];

    mysqli_query($koneksi, "UPDATE bahan SET nama_bahan = '$nama', stok = '$stok', satuan = '$satuan' WHERE id_bahan = '$id'");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Bahan | Kebab App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../../layout/style-input.php";?>

</head>

<body>
    <div class="content">
        <div class="header">
            <h2><i class="fas fa-carrot"></i> Edit Bahan</h2>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <form method="post">
            <div class="form-group">
                <label>Nama Bahan</label>
                <input type="text" name="nama" value="<?= $data['nama_bahan']; ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" step="0.01" name="stok" value="<?= $data['stok']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="satuan" value="<?= $data['satuan']; ?>" required>
                </div>
            </div>

            <button type="submit" name="update">Update</button>
        </form>

        <?php include "../../layout/choose.php"; ?>
    </div>
</body>

</html>
