<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

// ambil semua bahan
$bahan = mysqli_query($koneksi, "SELECT * FROM bahan");

if (isset($_POST['simpan'])) {

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];

    // 1️⃣ insert menu
    $insertMenu = mysqli_query($koneksi, "
        INSERT INTO menu (nama_menu, harga)
        VALUES ('$nama', '$harga')
    ");

    if ($insertMenu) {

        $id_menu = mysqli_insert_id($koneksi);

        // 2️⃣ insert resep (menu_bahan)
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

    } else {
        echo "Gagal menyimpan menu";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Menu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.4);
}
.modal-content {
    background: #fff;
    width: 90%;
    max-width: 400px;
    margin: 10% auto;
    padding: 20px;
}
</style>
</head>
<body>
    <div class="content">
        <h2>Tambah Menu</h2>

        <form method="post">

            <label>Nama Menu</label><br>
            <input type="text" name="nama" required><br><br>

            <label>Harga</label><br>
            <input type="number" name="harga" required><br><br>

            <button type="button" onclick="openModal()">Atur Resep</button>
            <br><br>

            <!-- MODAL -->
            <div class="modal" id="modalResep">
                <div class="modal-content">
                    <h3>Resep Menu</h3>

                    <?php while ($b = mysqli_fetch_assoc($bahan)) : ?>
                        <label><?= $b['nama_bahan'] ?> (<?= $b['satuan'] ?>)</label><br>
                        <input type="number" step="0.01" name="bahan[<?= $b['id_bahan'] ?>]" placeholder="Takaran">
                        <br><br>
                    <?php endwhile; ?>

                    <button type="button" onclick="closeModal()">Selesai</button>
                </div>
            </div>

            <br>
            <button type="submit" name="simpan">Simpan Menu</button>

        </form>
                       
        <script>
        function openModal() {
            document.getElementById('modalResep').style.display = 'block';
        }
        function closeModal() {
            document.getElementById('modalResep').style.display = 'none';
        }
        </script>

        <?php include "../../layout/choose.php"; ?>
    </div>
</body>
</html>
