<?php
session_start();
include 'koneksi.php';

if(!isset($_GET['id'])){
    die("ID pesanan tidak ditemukan");
}

$id_pesanan = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pesanan
WHERE id_pesanan='$id_pesanan'
"));

if(!$data){
    die("Pesanan tidak ditemukan");
}

if(isset($_POST['simpan'])){

    $metode = mysqli_real_escape_string(
        $conn,
        $_POST['metode']
    );

    mysqli_query($conn,"
        UPDATE pesanan
        SET metode_bayar='$metode'
        WHERE id_pesanan='$id_pesanan'
    ");

    header("Location: bayar.php?id=$id_pesanan");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Ubah Metode Pembayaran</title>

<style>
body{
    font-family:Arial;
    background:#f5f5f5;
}

.container{
    width:600px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,.1);
}

h2{
    margin-bottom:20px;
}

.radio{
    display:block;
    margin:15px 0;
}

.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#f58220;
    color:#fff;
    font-weight:bold;
    cursor:pointer;
}

.back{
    display:inline-block;
    margin-bottom:15px;
    background:#ddd;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
    color:#000;
}
</style>
</head>

<body>

<div class="container">

<a href="bayar.php?id=<?= $id_pesanan ?>" class="back">
← Kembali
</a>

<h2>Ganti Metode Pembayaran</h2>

<form method="POST">

<label class="radio">
<input type="radio"
       name="metode"
       value="Transfer Bank"
       <?= $data['metode_bayar']=='Transfer Bank' ? 'checked' : '' ?>>
Transfer Bank
</label>

<label class="radio">
<input type="radio"
       name="metode"
       value="E-Wallet"
       <?= $data['metode_bayar']=='E-Wallet' ? 'checked' : '' ?>>
E-Wallet
</label>

<label class="radio">
<input type="radio"
       name="metode"
       value="COD"
       <?= $data['metode_bayar']=='COD' ? 'checked' : '' ?>>
COD
</label>

<button type="submit" name="simpan" class="btn">
Simpan Perubahan
</button>

</form>

</div>

</body>
</html>