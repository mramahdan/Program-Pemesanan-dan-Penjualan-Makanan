<?php
session_start();
include '../koneksi.php';

// proteksi admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

// DATA CARD
$totalPesanan = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pesanan"));

$totalUser = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));

$totalUang = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total) as total FROM pesanan
"))['total'] ?? 0;

$diproses = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM pesanan WHERE status_kirim='diproses'
"));

$selesai = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM pesanan WHERE status_kirim='selesai'
"));

// 🔥 DATA GRAFIK
$grafik = mysqli_query($conn,"
SELECT DATE(tanggal) as tgl, SUM(total) as total
FROM pesanan
GROUP BY DATE(tanggal)
ORDER BY tgl ASC
");

$tanggal = [];
$totalGrafik = [];

while($g = mysqli_fetch_assoc($grafik)){
    $tanggal[] = date('d M', strtotime($g['tgl']));
    $totalGrafik[] = (int)$g['total'];
}

// 🔥 PESANAN TERBARU
$recent = mysqli_query($conn,"
SELECT p.*, u.nama 
FROM pesanan p
JOIN users u ON p.id_user=u.id_user
ORDER BY p.id_pesanan DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
    margin:0;
}

.container{
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    background:#f58220;
    color:white;
    min-height:100vh;
    padding:20px;
}

.sidebar h2{
    margin-bottom:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    margin:10px 0;
    padding:10px;
    border-radius:6px;
}

.sidebar a:hover{
    background:white;
    color:#f58220;
}

/* CONTENT */
.content{
    flex:1;
    padding:30px;
}

/* CARD */
.grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
    margin-bottom:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.05);
}

.card h3{
    margin:0;
    font-size:14px;
    color:#888;
}

.card h1{
    margin-top:10px;
}

/* BOX */
.box{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

/* PESANAN LIST */
.list{
    background:white;
    padding:20px;
    border-radius:12px;
}

.item{
    display:flex;
    justify-content:space-between;
    border-bottom:1px solid #eee;
    padding:10px 0;
}

.badge{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    color:white;
}

.diproses{ background:#2196f3; }
.selesai{ background:#4caf50; }
</style>

</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin</h2>

    <a href="dashboard_admin.php">Dashboard</a>
    <a href="pesanan_admin.php">Pesanan</a>
    <a href="produk_admin.php">Produk</a>
    <a href="pelanggan_admin.php">Pelanggan</a>

    <!-- 🔥 TAMBAHAN -->
    <a href="pengiriman_admin.php">Pengiriman</a>

    <a href="../logout.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<h2>Dashboard Admin</h2>

<!-- CARD -->
<div class="grid">

<div class="card">
    <h3>Total Pesanan</h3>
    <h1><?= $totalPesanan ?></h1>
</div>

<div class="card">
    <h3>Total Penjualan</h3>
    <h1>Rp<?= number_format($totalUang,0,',','.') ?></h1>
</div>

<div class="card">
    <h3>Diproses</h3>
    <h1><?= $diproses ?></h1>
</div>

<div class="card">
    <h3>Selesai</h3>
    <h1><?= $selesai ?></h1>
</div>

</div>

<!-- BOX -->
<div class="box">

<!-- GRAFIK -->
<div class="card">
    <h3>Grafik Penjualan</h3>
    <canvas id="grafikPenjualan"></canvas>
</div>

<!-- PESANAN TERBARU -->
<div class="list">
    <h3>Pesanan Terbaru</h3>

    <?php while($r = mysqli_fetch_assoc($recent)){ ?>

    <div class="item">
        <div>
            <b>#<?= $r['id_pesanan'] ?></b><br>
            <?= $r['nama'] ?>
        </div>

        <div>
            <span class="badge <?= $r['status'] ?>">
                <?= ucfirst($r['status']) ?>
            </span>
        </div>
    </div>

    <?php } ?>

</div>

</div>

</div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('grafikPenjualan');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Penjualan',
            data: <?= json_encode($totalGrafik) ?>,
            borderWidth: 3,
            tension: 0.3
        }]
    }
});
</script>

</body>
</html>