<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$q = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY id_menu DESC");

$menus = [];
$totalHarga = 0;

while ($row = mysqli_fetch_assoc($q)) {
    $menus[] = $row;
    $totalHarga += $row['harga'];
}

$totalMenu = count($menus);
$avgHarga = $totalMenu > 0 ? $totalHarga / $totalMenu : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu | Kebab App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "../../layout/style-list.php";?>
</head>

<body>
<div class="content">

<div class="header">
    <h2><i class="fas fa-utensils"></i> Data Menu</h2>
    <a href="tambah.php" class="btn-add">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
</div>

<!-- SUMMARY -->
<div class="summary-cards">
    <div class="summary-card total">
        <div class="summary-icon" style="background:#ffe1e8;color: #ff4d6d">
            <i class="fas fa-hamburger"></i>
        </div>
        <div>
            <h3 id="totalMenu"><?= $totalMenu ?></h3>
            <p>Total Menu</p>
        </div>
    </div>

    <div class="summary-card transactions">
        <div class="summary-icon" style="background:#e8f5e9;color: #0089d8">
            <i class="fas fa-tags"></i>
        </div>
        <div>
            <h3>Rp <?= number_format($avgHarga,0,',','.') ?></h3>
            <p>Rata-rata Harga</p>
        </div>
    </div>
</div>
<!-- SEARCH & SORT -->
<div class="search-filter-container">
    <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari menu...">
    </div>

    <select class="filter-select" id="sortBy">
        <option value="newest">Terbaru</option>
        <option value="name_asc">Nama A-Z</option>
        <option value="name_desc">Nama Z-A</option>
        <option value="price_asc">Harga Termurah</option>
        <option value="price_desc">Harga Termahal</option>
    </select>
</div>

<!-- TABLE -->
<div class="table-container">
<?php if ($totalMenu > 0): ?>
<table id="menuTable">
<thead>
<tr>
    <th>No</th>
    <th>Nama Menu</th>
    <th>Harga</th>
    <th>Kategori</th>
    <th>Resep</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody id="tableBody">

<?php $no=1; foreach($menus as $m): ?>
<tr 
 data-name="<?= strtolower($m['nama_menu']) ?>"
 data-price="<?= $m['harga'] ?>"
>
    <td><?= $no++ ?></td>
    <td><strong><?= htmlspecialchars($m['nama_menu']) ?></strong></td>
    <td class="price-tag">Rp <?= number_format($m['harga'],0,',','.') ?></td>
    <td>
        <span class="category-badge">
            <?= htmlspecialchars($m['kategori'] ?? '-') ?>
        </span>
    </td>
    <td>
        <button class="btn btn-view view-resep-btn"
            data-id="<?= $m['id_menu'] ?>"
            data-name="<?= htmlspecialchars($m['nama_menu']) ?>">
            <i class="fas fa-eye"></i> Lihat
        </button>
    </td>
    <td class="action-cell">
        <a href="edit.php?id=<?= $m['id_menu'] ?>" class="btn btn-edit">
            Edit
        </a>
        <a href="hapus.php?id=<?= $m['id_menu'] ?>"
           class="btn btn-delete delete-btn"
           data-menu="<?= htmlspecialchars($m['nama_menu']) ?>">
           Hapus
        </a>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
<?php else: ?>
<div class="empty-state">
    <i class="fas fa-utensils"></i>
    <h3>Belum Ada Menu</h3>
</div>
<?php endif; ?>
</div>

<!-- MODAL RESEP -->
<div class="modal" id="modalResep">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle"></h3>
            <button class="close-btn" id="closeModal">&times;</button>
        </div>
        <div class="resep-content" id="isiResep"></div>
        <div class="modal-footer">
            <button class="btn-close" id="closeModalBtn">Tutup</button>
        </div>
    </div>
</div>

<?php include "../../layout/choose.php"; ?>
</div>

<script>
/* SEARCH */
document.getElementById('searchInput').addEventListener('input', function(){
    let q=this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(r=>{
        r.style.display = r.dataset.name.includes(q) ? '' : 'none';
    });
});

/* SORT */
document.getElementById('sortBy').addEventListener('change', function(){
    let rows=[...document.querySelectorAll('#tableBody tr')];
    let v=this.value;

    rows.sort((a,b)=>{
        if(v==='name_asc') return a.dataset.name.localeCompare(b.dataset.name);
        if(v==='name_desc') return b.dataset.name.localeCompare(a.dataset.name);
        if(v==='price_asc') return a.dataset.price-b.dataset.price;
        if(v==='price_desc') return b.dataset.price-a.dataset.price;
        return 0;
    });

    rows.forEach((r,i)=>{
        r.children[0].innerText=i+1;
        document.getElementById('tableBody').appendChild(r);
    });
});

/* DELETE */
document.querySelectorAll('.delete-btn').forEach(b=>{
    b.onclick=e=>{
        e.preventDefault();
        if(confirm('Hapus menu "'+b.dataset.menu+'"?')){
            location.href=b.href;
        }
    }
});

/* MODAL RESEP */
const modal=document.getElementById('modalResep');
document.querySelectorAll('.view-resep-btn').forEach(b=>{
    b.onclick=()=>{
        modal.style.display='flex';
        document.getElementById('modalTitle').innerText='Resep '+b.dataset.name;
        fetch('resep.php?id='+b.dataset.id)
            .then(r=>r.text())
            .then(t=>document.getElementById('isiResep').innerHTML=t);
    };
});
['closeModal','closeModalBtn'].forEach(id=>{
    document.getElementById(id).onclick=()=>modal.style.display='none';
});
</script>
</body>
</html>
