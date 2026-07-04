<?php
session_start();
include 'koneksi.php';

$id_user = $_SESSION['user']['id_user'];

$user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users WHERE id_user='$id_user'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Profil Saya</title>

<style>
body{margin:0;font-family:Segoe UI;background:#d9e0e7;}
.container{display:flex;}

.sidebar{
    width:250px;
    background:#8fb5d4;
    min-height:100vh;
    padding:20px;
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

.active{background:#7ed957 !important;color:white !important;}

.content{flex:1;padding:30px;}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
}

td{
    padding:15px;
    border:1px solid #ddd;
}

.label{
    background:#d8e1b3;
    font-weight:bold;
    width:200px;
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
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="pesanan.php">Pesanan Saya</a>
        <a href="profil.php" class="active">Profil Saya</a>
        <a href="alamat.php">Alamat Saya</a>
        <a href="logout.php">Keluar</a>
    </div>
</div>

<div class="content">

<h2>Profil Saya</h2>

<a href="detail_pesanan.php?id=<?= $_SESSION['last_id_pesanan'] ?? '' ?>" class="btn-kembali">
← Kembali ke Detail Pesanan
</a>

<table>
<tr>
<td class="label">Nama</td>
<td><?= $user['nama'] ?></td>
</tr>

<tr>
<td class="label">Email</td>
<td><?= $user['email'] ?? '-' ?></td>
</tr>

<tr>
<td class="label">Telepon</td>
<td><?= $user['telepon'] ?? '-' ?></td>
</tr>
</table>

</div>
</div>

</body>
</html>