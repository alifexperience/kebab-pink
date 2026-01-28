<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$query = mysqli_query($koneksi, "SELECT * FROM penjualan ORDER BY id_penjualan DESC");

$penjualan = [];
$totalPenjualan = 0;
$penjualanHariIni = 0;
$tanggalHariIni = date('Y-m-d');

while ($row = mysqli_fetch_assoc($query)) {
    $penjualan[] = $row;
    $totalPenjualan += $row['total'];

    if (date('Y-m-d', strtotime($row['tanggal'])) === $tanggalHariIni) {
        $penjualanHariIni += $row['total'];
    }
}

$totalRows = count($penjualan);
$rataRata = $totalRows > 0 ? $totalPenjualan / $totalRows : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan | Kebab App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php include "../../layout/style-list.php";?>
</head>

<body>
<div class="content">

<div class="header">
    <h2><i class="fas fa-chart-line"></i> Data Penjualan</h2>
    <a href="tambah.php" class="btn-add"><i class="fas fa-plus"></i> Penjualan Baru</a>
</div>

<!-- SUMMARY -->
<div class="summary-cards">
    <div class="summary-card total">
        <div class="summary-icon" style="background:#ffe1e8;color:#ff4d6d">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <h3>Rp <?= number_format($totalPenjualan,0,',','.') ?></h3>
            <small>Total Penjualan</small>
        </div>
    </div>

    <div class="summary-card today">
        <div class="summary-icon" style="background:#e8f5e9;color:#ff9800">
            <i class="fas fa-sun"></i>
        </div>
        <div>
            <h3>Rp <?= number_format($penjualanHariIni,0,',','.') ?></h3>
            <small>Hari Ini</small>
        </div>
    </div>

    <div class="summary-card transactions">
        <div class="summary-icon" style="background:#e3f2fd;color:#2196f3">
            <i class="fas fa-receipt"></i>
        </div>
        <div>
            <h3 id="totalTransaksi"><?= $totalRows ?></h3>
            <small>Total Transaksi</small>
        </div>
    </div>

    <div class="summary-card average">
        <div class="summary-icon" style="background:#f3e5f5;color:#9c27b0">
            <i class="fas fa-calculator"></i>
        </div>
        <div>
            <h3>Rp <?= number_format($rataRata,0,',','.') ?></h3>
            <small>Rata-rata</small>
        </div>
    </div>
</div>

<!-- SEARCH & FILTER -->
<div class="search-filter-container">
    <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari ID Transaksi...">
    </div>
</div>

<!-- TABLE -->
<div class="table-container">
<table>
<thead>
<tr>
    <th>No</th>
    <th>ID Transaksi</th>
    <th>Tanggal</th>
    <th>Status</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody id="tableBody">
<?php $no=1; foreach($penjualan as $p): 
$transId = 'TRX'.str_pad($p['id_penjualan'],6,'0',STR_PAD_LEFT);
$status = $p['status'] ?? 'Lunas';
$class = $status=='Lunas'?'status-paid':($status=='Pending'?'status-pending':'status-cancelled');
?>
<tr data-date="<?= date('Y-m-d',strtotime($p['tanggal'])) ?>">
    <td><?= $no++ ?></td>
    <td><b><?= $transId ?></b></td>
    <td><?= date('d M Y H:i',strtotime($p['tanggal'])) ?></td>
    <td><span class="status-badge <?= $class ?>"><?= $status ?></span></td>
    <td class="amount">Rp <?= number_format($p['total'],0,',','.') ?></td>
    <td class="action-cell">
        <a href="detail.php?id=<?= $p['id_penjualan'] ?>" class="btn btn-view">Detail</a>
        <a href="cetak.php?id=<?= $p['id_penjualan'] ?>" class="btn btn-print" target="_blank">Cetak</a>
        <a href="hapus.php?id=<?= $p['id_penjualan'] ?>" class="btn btn-delete delete-btn"
           data-id="<?= $transId ?>">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<?php include "../../layout/choose.php"; ?>
</div>

<script>
/* FILTER TANGGAL */
function applyFilter(){
    let s=document.getElementById('startDate').value;
    let e=document.getElementById('endDate').value;
    let count=0;
    document.querySelectorAll('#tableBody tr').forEach(r=>{
        let d=r.dataset.date;
        if(d>=s && d<=e){r.style.display='';count++}
        else r.style.display='none';
    });
    document.getElementById('totalTransaksi').innerText=count;
}
function resetFilter(){
    document.querySelectorAll('#tableBody tr').forEach(r=>r.style.display='');
}

/* KONFIRMASI HAPUS */
document.querySelectorAll('.delete-btn').forEach(btn=>{
    btn.onclick=e=>{
        e.preventDefault();
        if(confirm('Hapus transaksi '+btn.dataset.id+' ?')){
            location.href=btn.href;
        }
    }
});

const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    let visible = 0;

    document.querySelectorAll('#tableBody tr').forEach(row => {
        const text = row.innerText.toLowerCase();
        if (text.includes(keyword)) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    // update total transaksi saat search
    document.getElementById('totalTransaksi').innerText = visible;
});
searchInput.addEventListener('input', function () {
    this.parentElement.classList.toggle('active', this.value.length > 0);
});
</script>

</body>
</html>
