<?php
session_start();
include 'koneksi.php';

/* AMBIL ID */
$id = $_GET['id'] ?? null;

if(!$id){
    die("ID tidak ditemukan");
}

/* SIMPAN SESSION */
$_SESSION['last_id_pesanan'] = $id;

/* PESANAN */
$pesanan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pesanan WHERE id_pesanan='$id'
"));

if(!$pesanan){
    die("Pesanan tidak ditemukan");
}

/* USER */
$user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users WHERE id_user='{$pesanan['id_user']}'
"));

/* DETAIL */
$detail = mysqli_query($conn,"
SELECT * FROM detail_pesanan WHERE id_pesanan='$id'
");

/* STATUS PEMBAYARAN */
$status = strtolower($pesanan['status'] ?? 'diproses');

/* STATUS PENGIRIMAN (🔥 PENTING) */
$statusKirim = strtolower($pesanan['status_kirim'] ?? 'diproses');

/* WARNA STATUS PEMBAYARAN */
if ($status == 'diproses') {
    $warna = '#fbc02d';
    $text = 'Diproses';
} elseif ($status == 'dikirim') {
    $warna = '#2196f3';
    $text = 'Dikirim';
} elseif ($status == 'selesai') {
    $warna = '#4caf50';
    $text = 'Selesai';
} else {
    $warna = '#29b6f6';
    $text = ucfirst($status);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pesanan</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f5f5f5;
    padding:20px;
}

.container{
    display:flex;
    max-width:1200px;
    margin:auto;
    background:#dfe7ef;
}

.sidebar{
    width:250px;
    background:#8fbfe0;
    padding:20px;
    text-align:center;
}

.profile img{
    width:80px;
    height:80px;
    border-radius:50%;
    margin-bottom:10px;
}

.menu{
    display:block;
    background:#fff;
    padding:10px;
    margin-bottom:10px;
    text-decoration:none;
    font-weight:bold;
    color:#000;
    border-radius:5px;
}

.menu:hover{
    background:#7ed957;
    color:#fff;
}

.active{
    background:#7ed957;
    color:#fff;
}

.content{
    flex:1;
    padding:30px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.status{
    padding:8px 15px;
    border-radius:20px;
    color:#fff;
    font-weight:bold;
}

/* 🔥 PENGIRIMAN STEP */
.pengiriman{
    display:flex;
    justify-content:space-between;
    margin:20px 0;
}

.step{
    flex:1;
    text-align:center;
    padding:10px;
    border-radius:10px;
    margin:0 5px;
    background:#ccc;
    color:#fff;
    font-weight:bold;
}

.active-step{
    background:#4caf50;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
}

th{
    background:#dce9bc;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
}

.total-box{
    width:300px;
    margin-left:auto;
    margin-top:20px;
}

.total-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}

.total{
    color:green;
    font-weight:bold;
}

.action{
    margin-top:30px;
    display:flex;
    gap:10px;
}

.btn{
    padding:12px 15px;
    border-radius:8px;
    text-decoration:none;
    color:#fff;
    font-weight:bold;
}

.bayar{background:#f58220;}
.invoice{background:#28a745;}
</style>
</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="profile">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
        <h3><?= $user['nama'] ?></h3>
        <p>Pelanggan</p>
    </div>

    <a href="dashboard.php" class="menu">Dashboard</a>
    <a href="pesanan.php" class="menu active">Pesanan</a>
    <a href="profil.php" class="menu">Profil</a>
    <a href="alamat.php" class="menu">Alamat</a>
    <a href="logout.php" class="menu">Logout</a>

</div>

<!-- CONTENT -->
<div class="content">

    <div class="header">
        <h2>Detail Pesanan</h2>

        <!-- STATUS PEMBAYARAN -->
        <span class="status" style="background:<?= $warna ?>">
            <?= $text ?>
        </span>
    </div>

    <!-- 🔥 STATUS PENGIRIMAN (FIX) -->
    <div class="pengiriman">

        <div class="step <?= ($statusKirim=='diproses' || $statusKirim=='dikirim' || $statusKirim=='selesai') ? 'active-step' : '' ?>">
            Diproses
        </div>

        <div class="step <?= ($statusKirim=='dikirim' || $statusKirim=='selesai') ? 'active-step' : '' ?>">
            Dikirim
        </div>

        <div class="step <?= ($statusKirim=='selesai') ? 'active-step' : '' ?>">
            Selesai
        </div>

    </div>

    <div class="info">
        <table>
            <tr>
                <td>ID</td>
                <td><b>#<?= $pesanan['id_pesanan'] ?></b></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td><b><?= $pesanan['tanggal'] ?></b></td>
            </tr>
            <tr>
                <td>Metode</td>
                <td><b><?= $pesanan['metode_bayar'] ?></b></td>
            </tr>
            <tr>
                <td>Total</td>
                <td><b>Rp <?= number_format($pesanan['total'],0,',','.') ?></b></td>
            </tr>
        </table>
    </div>

    <h3>Produk</h3>

    <table>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>

        <?php while($r = mysqli_fetch_assoc($detail)){ 

            $nama = $r['nama_produk'] ?? 'Menu';
            $variasi = $r['variasi'] ?? '';

            $namaFinal = $nama;
            if(!empty($variasi)){
                $namaFinal .= " (" . $variasi . ")";
            }
        ?>

        <tr>
            <td><?= $namaFinal ?></td>
            <td>Rp <?= number_format($r['harga'],0,',','.') ?></td>
            <td><?= $r['jumlah'] ?></td>
            <td>Rp <?= number_format($r['subtotal'],0,',','.') ?></td>
        </tr>

        <?php } ?>
    </table>

    <div class="total-box">
        <div class="total-row">
            <span>Subtotal</span>
            <span>Rp <?= number_format($pesanan['total'] - $pesanan['ongkir'],0,',','.') ?></span>
        </div>

        <div class="total-row">
            <span>Ongkir</span>
            <span>Rp <?= number_format($pesanan['ongkir'],0,',','.') ?></span>
        </div>

        <div class="total-row total">
            <span>Total</span>
            <span>Rp <?= number_format($pesanan['total'],0,',','.') ?></span>
        </div>
    </div>

    <div class="action">

        <?php if($pesanan['status'] == 'diproses'){ ?>
            <a href="bayar.php?id=<?= $pesanan['id_pesanan'] ?>" class="btn bayar">
                Bayar Sekarang
            </a>
        <?php } ?>

        <a href="cetak_struk.php?id=<?= $pesanan['id_pesanan'] ?>" class="btn invoice">
            Lihat Struk
        </a>

    </div>

</div>

</div>

</body>
</html>