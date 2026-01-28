<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$id = $_GET['id'];

// ambil data menu
$menu = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = '$id'");
$dataMenu = mysqli_fetch_assoc($menu);

// ambil semua bahan
$bahan = mysqli_query($koneksi, "SELECT * FROM bahan");

// ambil resep menu lama
$resep = [];
$qResep = mysqli_query($koneksi, "
    SELECT * FROM menu_bahan WHERE id_menu = '$id'
");
while ($r = mysqli_fetch_assoc($qResep)) {
    $resep[$r['id_bahan']] = $r['jumlah'];
}

if (isset($_POST['update'])) {

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];

    // 1️⃣ update menu
    $updateMenu = mysqli_query($koneksi, "
        UPDATE menu SET
            nama_menu = '$nama',
            harga = '$harga'
        WHERE id_menu = '$id'
    ");

    if ($updateMenu) {

        // 2️⃣ hapus resep lama
        mysqli_query($koneksi, "
            DELETE FROM menu_bahan WHERE id_menu = '$id'
        ");

        // 3️⃣ insert resep baru
        if (!empty($_POST['bahan'])) {
            foreach ($_POST['bahan'] as $id_bahan => $jumlah) {
                if ($jumlah > 0) {
                    mysqli_query($koneksi, "
                        INSERT INTO menu_bahan (id_menu, id_bahan, jumlah)
                        VALUES ('$id', '$id_bahan', '$jumlah')
                    ");
                }
            }
        }

        header("Location: index.php");
        exit;

    } else {
        echo "Gagal update menu";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Menu</title>
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
        <h2>Edit Menu</h2>

        <form method="post">

            <label>Nama Menu</label><br>
            <input type="text" name="nama"
                value="<?= $dataMenu['nama_menu'] ?>" required>
            <br><br>

            <label>Harga</label><br>
            <input type="number" name="harga"
                value="<?= $dataMenu['harga'] ?>" required>
            <br><br>

            <button type="button" onclick="openModal()">Edit Resep</button>
            <br><br>

            <!-- MODAL RESEP -->
            <div class="modal" id="modalResep">
                <div class="modal-content">
                    <h3>Resep Menu</h3>

                    <?php while ($b = mysqli_fetch_assoc($bahan)) : ?>
                        <label><?= $b['nama_bahan'] ?> (<?= $b['satuan'] ?>)</label><br>
                        <input type="number"
                            name="bahan[<?= $b['id_bahan'] ?>]"
                            value="<?= $resep[$b['id_bahan']] ?? '' ?>"
                            placeholder="Jumlah">
                        <br><br>
                    <?php endwhile; ?>

                    <button type="button" onclick="closeModal()">Selesai</button>
                </div>
            </div>

            <br>
            <button type="submit" name="update">Update Menu</button>

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
