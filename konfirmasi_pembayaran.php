<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

/* AMBIL PESANAN (SOURCE UTAMA STATUS) */
$pesanan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pesanan WHERE id_pesanan='$id'
"));

if(!$pesanan){
    die("Pesanan tidak ditemukan");
}

/* AMBIL PEMBAYARAN TERAKHIR */
$pembayaran = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pembayaran 
WHERE id_pesanan='$id'
ORDER BY id_pembayaran DESC 
LIMIT 1
"));

/* STATUS */
$status = $pesanan['status'] ?? 'Diproses';

/* WARNA */
if ($status == 'Selesai') {
    $warna = '#4caf50';
} elseif ($status == 'Menunggu Verifikasi') {
    $warna = '#ff9800';
} elseif ($status == 'Menunggu Pengiriman') {
    $warna = '#2196f3';
} else {
    $warna = '#9e9e9e';
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Konfirmasi Pembayaran</title>
<style>
body{font-family:Arial;background:#f5f5f5;}
.container{width:600px;margin:40px auto;}
.card{background:#fff;border-radius:10px;overflow:hidden;}
.header{background:#f58220;color:#fff;text-align:center;padding:15px;}
td{padding:12px;border-bottom:1px solid #eee;}
.status{color:#fff;padding:5px 10px;border-radius:20px;}
.btn{display:block;padding:12px;background:#ddd;text-align:center;text-decoration:none;}
</style>
</head>

<body>

<div class="container">

<div class="card">

<div class="header">PEMBAYARAN BERHASIL</div>

<table width="100%">
<tr><td>ID</td><td>#<?= $id ?></td></tr>
<tr><td>Nama</td><td><?= $pembayaran['nama_pengirim'] ?? '-' ?></td></tr>
<tr><td>Metode</td><td><?= $pembayaran['bank'] ?? '-' ?></td></tr>
<tr><td>No</td><td><?= $pembayaran['no_rekening'] ?? '-' ?></td></tr>
<tr><td>Total</td><td>Rp <?= number_format($pesanan['total'] ?? 0) ?></td></tr>

<tr>
<td>Status</td>
<td>
    <span class="status" style="background:<?= $warna ?>">
        <?= $status ?>
    </span>
</td>
</tr>

</table>

<a href="detail_pesanan.php?id=<?= $id ?>" class="btn">
    ← Detail Pesanan
</a>

<a href="cetak_struk.php?id=<?= $id ?>" class="btn">
    🧾 Lihat Struk
</a>

</div>

</div>

</body>
</html>