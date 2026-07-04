<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];

$pesanan = mysqli_query($conn,"
SELECT * FROM pesanan
WHERE id_user='$id_user'
ORDER BY id_pesanan DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Pesanan Saya</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#d9e0e7;
}

.container{ display:flex; }

.sidebar{
    width:250px;
    background:#8fb5d4;
    min-height:100vh;
    padding:20px;
    box-sizing:border-box;
}

.menu a{
    display:block;
    background:white;
    padding:12px;
    margin-bottom:10px;
    text-decoration:none;
    text-align:center;
    border-radius:8px;
    font-weight:bold;
    color:black;
}

.active{
    background:#7ed957 !important;
    color:white !important;
}

.content{
    flex:1;
    padding:30px;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
}

th{
    background:#d8e1b3;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

.btn{
    background:#f58220;
    color:white;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
}

.btn-kembali{
    display:inline-block;
    background:#6c757d;
    color:white;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
    margin-bottom:15px;
}
</style>
</head>

<body>

<div class="container">

<div class="sidebar">
    <h3><?= $_SESSION['user']['nama']; ?></h3>

    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="pesanan.php" class="active">Pesanan Saya</a>
        <a href="profil.php">Profil Saya</a>
        <a href="alamat.php">Alamat Saya</a>
        <a href="logout.php">Keluar</a>
    </div>
</div>

<div class="content">

<h2>Pesanan Saya</h2>

<table>
<tr>
<th>ID</th>
<th>Tanggal</th>
<th>Total</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php while($row = mysqli_fetch_assoc($pesanan)){ ?>

<tr>
<td>#<?= $row['id_pesanan'] ?></td>
<td><?= $row['tanggal'] ?? '-' ?></td>
<td>Rp <?= number_format($row['total']) ?></td>
<td><?= $row['status'] ?? '-' ?></td>
<td>
<a href="detail_pesanan.php?id=<?= $row['id_pesanan'] ?>" class="btn">
Detail
</a>
</td>
</tr>

<?php } ?>

</table>

</div>
</div>

</body>
</html>