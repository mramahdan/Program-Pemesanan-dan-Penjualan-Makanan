<?php
session_start();
include '../koneksi.php';

if(isset($_POST['simpan'])){
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    mysqli_query($conn,"
    INSERT INTO produk(nama_produk,harga,stok,status)
    VALUES('$nama','$harga','$stok','tersedia')
    ");

    header("Location: produk_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

/* LAYOUT */
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

/* FORM */
.form-box{
    background:white;
    padding:25px;
    border-radius:10px;
    width:400px;
}

.form-box h2{
    margin-bottom:20px;
}

input{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:6px;
}

/* BUTTON */
.btn{
    padding:10px;
    border:none;
    border-radius:6px;
    color:white;
    cursor:pointer;
}

.simpan{ background:#28a745; }
.kembali{ background:#6c757d; text-decoration:none; padding:10px; display:inline-block; }

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
    <a href="../logout.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<div class="form-box">
    <h2>Tambah Produk</h2>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Produk" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <input type="number" name="stok" placeholder="Stok" required>

        <button type="submit" name="simpan" class="btn simpan">
            Simpan
        </button>
    </form>

    <br>
    <a href="produk_admin.php" class="kembali">← Kembali</a>
</div>

</div>
</div>

</body>
</html>

