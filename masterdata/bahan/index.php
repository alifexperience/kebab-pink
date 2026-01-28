<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$query = mysqli_query($koneksi, "SELECT * FROM bahan ORDER BY id_bahan DESC");

$bahan = [];
$totalBahan = 0;
$bahanRendah = 0;

while ($row = mysqli_fetch_assoc($query)) {
    $bahan[] = $row;
    $totalBahan++;

    if ($row['stok'] < 30) {
        $bahanRendah++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Bahan | Kebab App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "../../layout/style-list.php";?>
</head>

<body>
<div class="content">

<div class="header">
    <h2><i class="fas fa-carrot"></i> Data Bahan</h2>
    <a href="tambah.php" class="btn-add">
        <i class="fas fa-plus"></i> Tambah Bahan
    </a>
</div>

<!-- SUMMARY -->
<div class="summary-cards">
    <div class="summary-card bahan">
        <div class="summary-icon" style="background: #a2eba588;color:#4caf50">
            <i class="fas fa-boxes"></i>
        </div>
        <div>
            <h3 id="totalBahan"><?= $totalBahan ?></h3>
            <p>Total Bahan</p>
        </div>
    </div>

    <div class="summary-card today">
        <div class="summary-icon" style="background:#e8f5e9;color:#ff9800">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div>
            <h3 id="bahanRendah"><?= $bahanRendah ?></h3>
            <p>Bahan Stok Rendah</p>
        </div>
    </div>
</div>

<!-- SEARCH & FILTER -->
<div class="search-filter-container">
    <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari Bahan...">
    </div>

    <select class="filter-select" id="filterStock">
        <option value="">Semua Stok</option>
        <option value="high">Stok Tinggi</option>
        <option value="medium">Stok Sedang</option>
        <option value="low">Stok Rendah</option>
    </select>

    <select class="filter-select" id="sortBy">
        <option value="newest">Terbaru</option>
        <option value="oldest">Terlama</option>
        <option value="name_asc">Nama A-Z</option>
        <option value="name_desc">Nama Z-A</option>
        <option value="stock_asc">Stok Sedikit</option>
        <option value="stock_desc">Stok Banyak</option>
    </select>
</div>

<!-- TABLE -->
<div class="table-container">
<?php if ($totalBahan > 0): ?>
<table id="bahanTable">
<thead>
<tr>
    <th>No</th>
    <th>Nama Bahan</th>
    <th>Stok</th>
    <th>Satuan</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody id="tableBody">
<?php $no=1; foreach ($bahan as $b): 
    $stok = (int)$b['stok'];
    if ($stok >= 100) {
        $status = 'high'; $label='Tinggi'; $cls='stock-high'; $icon='fa-arrow-up';
    } elseif ($stok >= 30) {
        $status = 'medium'; $label='Sedang'; $cls='stock-medium'; $icon='fa-minus';
    } else {
        $status = 'low'; $label='Rendah'; $cls='stock-low'; $icon='fa-exclamation-triangle';
    }
?>
<tr data-status="<?= $status ?>" data-id="<?= $b['id_bahan'] ?>">
    <td><?= $no++ ?></td>
    <td><strong><?= htmlspecialchars($b['nama_bahan']) ?></strong></td>
    <td><span class="stock-value"><?= $stok ?></span></td>
    <td><?= htmlspecialchars($b['satuan']) ?></td>
    <td>
        <span class="stock-status <?= $cls ?>">
            <i class="fas <?= $icon ?>"></i> <?= $label ?>
        </span>
    </td>
    <td class="action-cell">
        <a href="edit.php?id=<?= $b['id_bahan'] ?>" class="btn btn-edit">
            Edit
        </a>
        <a href="hapus.php?id=<?= $b['id_bahan'] ?>" 
           class="btn btn-delete delete-btn"
           data-bahan="<?= htmlspecialchars($b['nama_bahan']) ?>">
            Hapus
        </a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<div class="empty-state">
    <i class="fas fa-carrot"></i>
    <h3>Tidak Ada Data Bahan</h3>
</div>
<?php endif; ?>
</div>

<?php include "../../layout/choose.php"; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
const rows = () => Array.from(document.querySelectorAll('#tableBody tr'));

// SEARCH
searchInput.oninput = () => {
    const q = searchInput.value.toLowerCase();
    rows().forEach(r=>{
        r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
};

// FILTER STOK
filterStock.onchange = () => {
    const f = filterStock.value;
    rows().forEach(r=>{
        r.style.display = (!f || r.dataset.status===f) ? '' : 'none';
    });
};

// SORT
sortBy.onchange = () => {
    let r = rows();
    r.sort((a,b)=>{
        switch(sortBy.value){
            case 'newest': return b.dataset.id - a.dataset.id;
            case 'oldest': return a.dataset.id - b.dataset.id;
            case 'name_asc': return a.children[1].innerText.localeCompare(b.children[1].innerText);
            case 'name_desc': return b.children[1].innerText.localeCompare(a.children[1].innerText);
            case 'stock_asc': return a.querySelector('.stock-value').innerText - b.querySelector('.stock-value').innerText;
            case 'stock_desc': return b.querySelector('.stock-value').innerText - a.querySelector('.stock-value').innerText;
        }
    });
    r.forEach((tr,i)=>{ tr.children[0].innerText=i+1; tableBody.appendChild(tr); });
};

// DELETE CONFIRM
document.querySelectorAll('.delete-btn').forEach(btn=>{
    btn.onclick = e=>{
        e.preventDefault();
        if(confirm(`Hapus bahan "${btn.dataset.bahan}" ?`)){
            location.href = btn.href;
        }
    }
});
});
</script>
</body>
</html>
