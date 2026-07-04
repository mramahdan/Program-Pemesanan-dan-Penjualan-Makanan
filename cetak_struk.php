<?php
session_start();
include 'koneksi.php';

if(!isset($_GET['id'])){
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

/* PESANAN */
$pesanan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pesanan
WHERE id_pesanan='$id'
"));

if(!$pesanan){
    die("Pesanan tidak ditemukan");
}

/* USER */
$user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users
WHERE id_user='{$pesanan['id_user']}'
"));

/* DETAIL */
$detail = mysqli_query($conn,"
SELECT *
FROM detail_pesanan
WHERE id_pesanan='$id'
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Struk Pemesanan</title>

<style>

body{
    font-family:'Segoe UI',sans-serif;
    background:#f4f6f9;
    padding:25px;
}

.container{
    width:850px;
    margin:auto;
    background:#fff;
    border-radius:15px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.header{
    background:#f58220;
    color:white;
    text-align:center;
    padding:20px;
    border-radius:12px;
    margin-bottom:25px;
}

.header h2{
    margin:0;
    font-size:28px;
}

.header p{
    margin-top:8px;
    opacity:.9;
}

.info{
    background:#fafafa;
    border:1px solid #eee;
    border-radius:10px;
    padding:18px;
    margin-bottom:25px;
}

.info p{
    margin:8px 0;
    font-size:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f58220;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

.text-center{
    text-align:center;
}

.text-right{
    text-align:right;
}

.summary-label{
    text-align:right;
    font-weight:bold;
    padding-right:25px;
}

.summary-value{
    text-align:right;
    font-weight:bold;
}

.total-row{
    background:#f1fff1;
}

.total-row td{
    color:#28a745;
    font-size:18px;
    font-weight:bold;
}

.action-buttons{
    margin-top:25px;
    display:flex;
    justify-content:center;
    gap:12px;
    flex-wrap:wrap;
}

.btn{
    text-decoration:none;
    padding:12px 18px;
    border-radius:8px;
    color:white;
    font-weight:bold;
    transition:.3s;
}

.btn:hover{
    opacity:.9;
}

.back{
    background:#6c757d;
}

.print{
    background:#28a745;
}

.home{
    background:#2196f3;
}

/* HILANGKAN TOMBOL SAAT PRINT */
@media print{

    body{
        background:white;
        padding:0;
    }

    .container{
        width:100%;
        margin:0;
        padding:0;
        box-shadow:none;
        border:none;
    }

    .action-buttons{
        display:none !important;
    }
}

</style>
</head>

<body>

<div class="container">

<div class="header">
    <h2>STRUK PEMESANAN</h2>
    <p>Food Order System</p>
</div>

<div class="info">
    <p><b>Nama Pelanggan :</b> <?= $user['nama'] ?? '-' ?></p>
    <p><b>ID Pesanan :</b> #<?= $id ?></p>
    <p><b>Metode Pembayaran :</b> <?= $pesanan['metode_bayar'] ?? '-' ?></p>
    <p><b>Tanggal :</b> <?= $pesanan['tanggal'] ?? '-' ?></p>
</div>

<table>

<tr>
    <th>Produk</th>
    <th width="120">Jumlah</th>
    <th width="170">Harga</th>
    <th width="170">Subtotal</th>
</tr>

<?php
$total = 0;

while($row = mysqli_fetch_assoc($detail)){

    $nama    = $row['nama_produk'] ?? 'Menu';
    $variasi = $row['variasi'] ?? '';
    $qty     = $row['jumlah'] ?? 0;
    $harga   = $row['harga'] ?? 0;
    $sub     = $row['subtotal'] ?? 0;

    $namaFinal = $nama;

    if(!empty($variasi)){
        $namaFinal .= " (" . $variasi . ")";
    }

    $total += $sub;
?>

<tr>
    <td><?= $namaFinal ?></td>

    <td class="text-center">
        <?= $qty ?>
    </td>

    <td class="text-right">
        Rp <?= number_format($harga,0,',','.') ?>
    </td>

    <td class="text-right">
        Rp <?= number_format($sub,0,',','.') ?>
    </td>
</tr>

<?php } ?>

<tr>
    <td colspan="3" class="summary-label">
        Subtotal
    </td>

    <td class="summary-value">
        Rp <?= number_format($total,0,',','.') ?>
    </td>
</tr>

<tr>
    <td colspan="3" class="summary-label">
        Ongkir
    </td>

    <td class="summary-value">
        Rp <?= number_format($pesanan['ongkir'] ?? 0,0,',','.') ?>
    </td>
</tr>

<tr class="total-row">
    <td colspan="3" class="summary-label">
        TOTAL
    </td>

    <td class="summary-value">
        Rp <?= number_format(
            $total + ($pesanan['ongkir'] ?? 0),
            0,
            ',',
            '.'
        ) ?>
    </td>
</tr>

</table>

<div class="action-buttons">

    <a href="detail_pesanan.php?id=<?= $id ?>"
       class="btn back">
       ← Detail Pesanan
    </a>

    <a href="#"
       onclick="window.print(); return false;"
       class="btn print">
       🖨 Download Struk
    </a>

    <a href="dashboard.php"
       class="btn home">
       🏠 Kembali ke Dashboard
    </a>

</div>

</div>

</body>
</html>