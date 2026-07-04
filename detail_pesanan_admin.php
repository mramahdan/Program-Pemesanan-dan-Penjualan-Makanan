<?php
session_start();
include '../koneksi.php';

// proteksi admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$id = $_GET['id'] ?? 0;

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT p.*, u.nama 
FROM pesanan p
JOIN users u ON p.id_user = u.id_user
WHERE p.id_pesanan='$id'
"));

$detail = mysqli_query($conn,"
SELECT * FROM detail_pesanan
WHERE id_pesanan='$id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan Admin</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

.container{
    width:80%;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

h2{
    margin-bottom:20px;
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

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:10px;
    color:white;
    font-weight:bold;
}

.diproses{ background:#2196f3; }
.dikirim{ background:#ff9800; }
.selesai{ background:#4caf50; }

/* BUTTON */
.btn{
    padding:10px 15px;
    text-decoration:none;
    border-radius:6px;
    color:white;
    font-weight:bold;
    display:inline-block;
    margin-top:10px;
}

.kirim{ background:#ff9800; }
.selesai{ background:#4caf50; }
.back{ background:#6c757d; }
</style>
</head>

<body>

<div class="container">

<h2>Detail Pesanan #<?= $id ?></h2>

<p><b>Nama:</b> <?= $data['nama'] ?></p>

<p>
<b>Status:</b> 
<span class="status <?= $data['status'] ?>">
    <?= ucfirst($data['status']) ?>
</span>
</p>

<table>
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>

<?php while($d = mysqli_fetch_assoc($detail)){ 

    $nama = $d['nama_produk'];
    if(!empty($d['variasi'])){
        $nama .= " (".$d['variasi'].")";
    }
?>

<tr>
    <td><?= $nama ?></td>
    <td><?= $d['jumlah'] ?></td>
    <td>Rp<?= number_format($d['subtotal'],0,',','.') ?></td>
</tr>

<?php } ?>

</table>

<br>

<!-- 🔥 TOMBOL STATUS -->
<?php if($data['status'] == 'diproses'){ ?>
    <a href="update_status.php?id=<?= $id ?>&status=dikirim" class="btn kirim">
        Kirim Pesanan 🚚
    </a>
<?php } ?>

<?php if($data['status'] == 'dikirim'){ ?>
    <a href="update_status.php?id=<?= $id ?>&status=selesai" class="btn selesai">
        Tandai Selesai ✅
    </a>
<?php } ?>

<br><br>

<a href="pesanan_admin.php" class="btn back">
    Kembali
</a>

</div>

</body>
</html>