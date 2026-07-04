<?php
session_start();
include '../koneksi.php';

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$pesanan = mysqli_query($conn,"
SELECT p.*, u.nama 
FROM pesanan p
JOIN users u ON p.id_user = u.id_user
ORDER BY p.id_pesanan DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Pesanan</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

.container{
    width:90%;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

/* 🔥 tombol kembali */
.back{
    display:inline-block;
    margin-bottom:15px;
    padding:8px 12px;
    background:#6c757d;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

.back:hover{
    background:#5a6268;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

th{
    background:#f58220;
    color:white;
}

.btn{
    padding:5px 10px;
    background:#28a745;
    color:white;
    text-decoration:none;
    border-radius:5px;
}
</style>
</head>

<body>

<div class="container">

<h2>Data Pesanan</h2>

<!-- 🔥 TOMBOL KEMBALI -->
<a href="dashboard_admin.php" class="back">← Kembali ke Dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Total</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while($p = mysqli_fetch_assoc($pesanan)){ ?>

<tr>
    <td>#<?= $p['id_pesanan'] ?></td>
    <td><?= $p['nama'] ?></td>
    <td>Rp<?= number_format($p['total'],0,',','.') ?></td>
    <td><?= $p['status'] ?></td>
    <td>
        <a href="detail_pesanan_admin.php?id=<?= $p['id_pesanan'] ?>" class="btn">
            Detail
        </a>
    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>