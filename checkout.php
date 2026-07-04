<?php
session_start();

include 'koneksi.php';

/* =========================
   FIX USER SESSION
========================= */
$id_user = $_SESSION['id_user'] ?? null;

if(!$id_user){
    die("Silakan login terlebih dahulu");
}

/* =========================
   KERANJANG
========================= */
$keranjang = $_SESSION['keranjang'] ?? [];

if(empty($keranjang)){
    header("Location: keranjang.php");
    exit;
}

/* =========================
   HITUNG SUBTOTAL AMAN
========================= */
$subtotal = 0;

foreach($keranjang as $item){

    $harga = $item['harga'] ?? 0;
    $qty   = $item['qty'] ?? 0;

    if($harga < 0) $harga = 0;
    if($qty < 0) $qty = 0;

    $subtotal += $harga * $qty;
}

/* =========================
   ONGKIR & TOTAL
========================= */
$ongkir = 5000;
$total  = $subtotal + $ongkir;

/* =========================
   USER DATA (OPTIONAL)
========================= */
$user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users WHERE id_user='$id_user'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

.container{
    width:90%;
    margin:30px auto;
    background:#e9ddc8;
    padding:30px;
    border-radius:10px;
}

.wrapper{
    display:flex;
    gap:40px;
}

.left{
    flex:1;
    border-right:1px solid #ccc;
    padding-right:30px;
}

.right{
    flex:1;
}

h2{
    margin-bottom:20px;
}

label{
    display:block;
    margin-top:15px;
    font-weight:600;
}

input,textarea{
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:8px;
    border:1px solid #ccc;
}

/* RINGKASAN */
.summary-item{
    display:grid;
    grid-template-columns: 1fr auto auto;
    gap:20px;
    margin-bottom:10px;
}

/* TOTAL */
.total{
    color:#f58220;
    font-weight:bold;
}

/* RADIO */
.radio{
    display:flex;
    align-items:center;
    gap:10px;
    margin:10px 0;
}

.radio input[type="radio"]{
    width:20px;
    height:20px;
    appearance:none;
    border:2px solid #bbb;
    border-radius:50%;
    cursor:pointer;
    position:relative;
}

.radio input[type="radio"]:checked{
    border:5px solid #f58220;
}

.radio input[type="radio"]:checked::after{
    content:"";
    width:8px;
    height:8px;
    background:#f58220;
    border-radius:50%;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}

/* BUTTON */
.btn{
    background:#f58220;
    color:white;
    padding:12px;
    border:none;
    border-radius:8px;
    width:100%;
    margin-top:20px;
    cursor:pointer;
}

.kembali{
    display:inline-block;
    margin-top:20px;
    background:#ccc;
    padding:10px;
    text-decoration:none;
    border-radius:6px;
}
</style>
</head>

<body>

<div class="container">

<form action="proses_checkout.php" method="POST">

<div class="wrapper">

<!-- LEFT -->
<div class="left">

<h2>Data Pemesanan</h2>

<label>Nama</label>
<input type="text" name="nama"
value="<?= $user['nama'] ?? '' ?>" required>

<label>No Telepon</label>
<input type="text" name="telepon"
value="<?= $user['telepon'] ?? '' ?>" required>

<label>Alamat</label>
<textarea name="alamat" required><?= $user['alamat'] ?? '' ?></textarea>

<label>Catatan</label>
<textarea name="catatan"></textarea>

<a href="keranjang.php" class="kembali">Kembali</a>

</div>

<!-- RIGHT -->
<div class="right">

<h2>Ringkasan Pesanan</h2>

<?php foreach($keranjang as $item){ 

    $nama  = $item['nama'] ?? 'Menu';
    $harga = $item['harga'] ?? 0;
    $qty   = $item['qty'] ?? 0;

    $variasi = $item['variasi'] ?? '';
    $namaFinal = $nama;

    if(!empty($variasi)){
        $namaFinal .= " (" . $variasi . ")";
    }
?>

<div class="summary-item">
    <div><?= $namaFinal ?></div>
    <div>Rp<?= number_format($harga,0,',','.') ?></div>
    <div>x<?= $qty ?></div>
</div>

<?php } ?>

<hr>

<div class="summary-item">
    <span>Subtotal</span>
    <span></span>
    <span>Rp<?= number_format($subtotal,0,',','.') ?></span>
</div>

<div class="summary-item">
    <span>Ongkir</span>
    <span></span>
    <span>Rp<?= number_format($ongkir,0,',','.') ?></span>
</div>

<div class="summary-item total">
    <span>Total</span>
    <span></span>
    <span>Rp<?= number_format($total,0,',','.') ?></span>
</div>

<hr>

<h3>Metode Pembayaran</h3>

<label class="radio">
    <input type="radio" name="pembayaran" value="Transfer Bank" checked>
    Transfer Bank
</label>

<label class="radio">
    <input type="radio" name="pembayaran" value="E-Wallet">
    E-Wallet
</label>

<label class="radio">
    <input type="radio" name="pembayaran" value="COD">
    COD
</label>

<button type="submit" class="btn">
    Buat Pesanan
</button>

</div>

</div>

</form>

</div>

</body>
</html>