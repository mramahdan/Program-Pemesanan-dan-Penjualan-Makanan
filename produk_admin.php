<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$data = mysqli_query($conn,"SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Produk</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

.container{
    display:flex;
}

.sidebar{
    width:220px;
    background:#f58220;
    color:white;
    min-height:100vh;
    padding:20px;
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

.content{
    flex:1;
    padding:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#f58220;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

.btn{
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
}

.hapus{ background:#dc3545; }
.tambah{ background:#28a745; margin-bottom:15px; display:inline-block; }
.update{ background:#2196f3; }
</style>
</head>

<body>

<div class="container">

<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard_admin.php">Dashboard</a>
    <a href="pesanan_admin.php">Pesanan</a>
    <a href="produk_admin.php">Produk</a>
    <a href="pelanggan_admin.php">Pelanggan</a>
    <a href="pengiriman_admin.php">Pengiriman</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">

<h2>Data Produk</h2>

<a href="tambah_produk.php" class="btn tambah">+ Tambah Produk</a>

<table>
<tr>
    <th>Nama</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Tambah Stok</th>
    <th>Aksi</th>
</tr>

<?php while($p=mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $p['nama_produk'] ?></td>
    <td>Rp<?= number_format($p['harga'],0,',','.') ?></td>
    <td><b><?= $p['stok'] ?></b></td>

    <!-- 🔥 TAMBAH STOK -->
    <td>
        <form action="update_stok.php" method="POST" style="display:flex;gap:5px;">
            <input type="hidden" name="id" value="<?= $p['id_produk'] ?>">

            <input type="number" name="tambah" min="1" required style="width:70px;">

            <button type="submit" class="btn update">
                Tambah
            </button>
        </form>
    </td>

    <td>
        <a href="hapus_produk.php?id=<?= $p['id_produk'] ?>" class="btn hapus">
            Hapus
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>