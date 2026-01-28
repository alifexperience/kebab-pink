<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$id_menu = $_GET['id'] ?? null;
if (!$id_menu) {
    header("Location: index.php");
    exit;
}

// ambil menu
$menu = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$id_menu'")
);

// ambil semua bahan
$bahan = mysqli_query($koneksi, "SELECT * FROM bahan");

// ambil resep lama
$qResep = mysqli_query($koneksi, "
    SELECT * FROM menu_bahan WHERE id_menu='$id_menu'
");

$resepLama = [];
while ($r = mysqli_fetch_assoc($qResep)) {
    $resepLama[$r['id_bahan']] = $r['jumlah'];
}

if (isset($_POST['simpan'])) {
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];

    // update menu
    mysqli_query($koneksi, "
        UPDATE menu 
        SET nama_menu='$nama', harga='$harga'
        WHERE id_menu='$id_menu'
    ");

    // hapus resep lama
    mysqli_query($koneksi, "
        DELETE FROM menu_bahan WHERE id_menu='$id_menu'
    ");

    // simpan resep baru
    if (!empty($_POST['bahan'])) {
        foreach ($_POST['bahan'] as $id_bahan => $jumlah) {
            if ($jumlah > 0) {
                mysqli_query($koneksi, "
                    INSERT INTO menu_bahan (id_menu, id_bahan, jumlah)
                    VALUES ('$id_menu', '$id_bahan', '$jumlah')
                ");
            }
        }
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu | Kebab App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../../layout/style-input.php"; ?>
    <?php include "../../layout/style-modal.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<div class="content">

    <div class="header">
        <h2><i class="fas fa-utensils"></i> Edit Menu</h2>
        <a href="index.php" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    <form method="post">
        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="nama" value="<?= $menu['nama_menu'] ?>" required>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $menu['harga'] ?>" required>
        </div>

        <button type="button" class="btn-resep" onclick="openModal()">
            <i class="fas fa-list"></i> Resep
        </button>

        <!-- MODAL RESEP -->
        <div class="modal-resep" id="modalResep">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="fas fa-list"></i> Edit Resep</h3>
                    <button class="close-btn" onclick="closeModal()">&times;</button>
                </div>

                <div class="modal-body">
                    <?php 
                    mysqli_data_seek($bahan, 0);
                    while ($b = mysqli_fetch_assoc($bahan)) : 
                        $jumlah = $resepLama[$b['id_bahan']] ?? 0;
                    ?>
                        <div class="bahan-item">
                            <div class="bahan-info">
                                <div class="bahan-nama"><?= $b['nama_bahan'] ?></div>
                                <div class="bahan-satuan">
                                    Stok: <?= $b['stok'] ?> <?= $b['satuan'] ?>
                                </div>
                            </div>
                            <input type="number"
                                name="bahan[<?= $b['id_bahan'] ?>]"
                                class="bahan-input"
                                value="<?= $jumlah ?>">
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-modal btn-secondary" onclick="closeModal()">Tutup</button>
                    <button type="button" class="btn-modal btn-primary" onclick="closeModal()">Simpan</button>
                </div>
            </div>
        </div>
        
        <button type="submit" name="simpan">Update</button>
    </form>

    <?php include "../../layout/choose.php"; ?>
</div>

<script>
function openModal() {
    document.getElementById('modalResep').style.display = 'block';
}
function closeModal() {
    document.getElementById('modalResep').style.display = 'none';
}
window.onclick = function(e) {
    const modal = document.getElementById('modalResep');
    if (e.target == modal) closeModal();
}
</script>

</body>
</html>
