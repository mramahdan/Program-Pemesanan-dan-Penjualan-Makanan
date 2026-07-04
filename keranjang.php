<?php
session_start();

$keranjang = $_SESSION['keranjang'] ?? [];

// AKSI
if(isset($_GET['aksi'])){
    $id = $_GET['id'];

    if($_GET['aksi'] == "tambah"){
        $_SESSION['keranjang'][$id]['qty']++;
    }

    if($_GET['aksi'] == "kurang"){
        $_SESSION['keranjang'][$id]['qty']--;
        if($_SESSION['keranjang'][$id]['qty'] <= 0){
            unset($_SESSION['keranjang'][$id]);
        }
    }

    if($_GET['aksi'] == "hapus"){
        unset($_SESSION['keranjang'][$id]);
    }

    header("Location: keranjang.php");
    exit;
}

// fallback nama
$listMenu = [
    1 => "Bakso Bakar",
    2 => "Mie Level Pentol",
    3 => "Mie Level",
    4 => "Pop Ice",
    5 => "Nutrisari",
    6 => "Jus Alpukat",
    7 => "Es Coklat Boba",
    8 => "Soto",
    9 => "Es Campur",
    10 => "Bakwan Goreng",
    11 => "Es Kopi Susu",
    12 => "Tahu Bakso",
    13 => "Tempe Goreng",
    14 => "Es Kelapa",
    15 => "Jus Mangga",
    16 => "Air Mineral",
    17 => "Air Aqua",
    18 => "Nasi Goreng",
    19 => "Seblak Pedas Komplit",
    20 => "Nasi Ayam Goreng"
];

// TOTAL
$total = 0;
foreach($keranjang as $id => $item){
    $harga = $item['harga'] ?? 0;
    $qty   = $item['qty'] ?? 0;
    $total += $harga * $qty;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Keranjang</title>

<style>

body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

.container{
    width:95%;
    margin:30px auto;
    background:white;
    padding:20px;
    border-radius:12px;
}

h2{
    margin-bottom:20px;
}

/* TABLE */
.table{
    width:100%;
    border:1px solid #ddd;
    border-radius:10px;
    overflow:hidden;
}

.row{
    display:grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 80px;
    align-items:center;
    justify-items:center; /* 🔥 biar center semua */
    padding:15px;
    border-bottom:1px solid #eee;
}

.header{
    background:#f9f9f9;
    font-weight:bold;
}

/* PRODUK */
.produk{
    display:flex;
    align-items:center;
    gap:15px;
    justify-self:start;
}

.produk img{
    width:80px;
    border-radius:10px;
}

.nama-produk{
    font-weight:600;
    font-size:16px;
}

/* QTY (🔥 FIX UTAMA) */
.qty{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    height:100%;
}

.btn{
    background:#f58220;
    color:white;
    border:none;
    width:35px;
    height:35px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
    font-weight:bold;
    font-size:18px;
}

.qty span{
    min-width:30px;
    text-align:center;
    font-weight:bold;
    font-size:16px;
}

/* TOTAL BOX */
.total-box{
    margin-top:20px;
    background:#e9ddc8;
    padding:20px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.checkout{
    background:#f58220;
    color:white;
    padding:10px 20px;
    border-radius:8px;
    text-decoration:none;
}

.kembali{
    margin-top:15px;
    display:inline-block;
    background:#f58220;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
}

</style>
</head>

<body>

<div class="container">

<h2>Keranjang Belanja</h2>

<div class="table">

<!-- HEADER -->
<div class="row header">
    <div>Produk</div>
    <div>Harga</div>
    <div>Jumlah</div>
    <div>Subtotal</div>
    <div>Aksi</div>
</div>

<!-- DATA -->
<?php if(empty($keranjang)){ ?>

<div class="row">
    <div>Keranjang kosong</div>
</div>

<?php } ?>

<?php foreach($keranjang as $id => $item){ 

    $nama  = $item['nama'] ?? ($listMenu[$id] ?? 'Menu');
    $harga = $item['harga'] ?? 0;
    $qty   = $item['qty'] ?? 0;
    $img   = $item['img'] ?? '';

    // 🔥 VARIASI
    $variasi = $item['variasi'] ?? '';
    $namaFinal = $nama;

    if($variasi != ''){
        $namaFinal .= " (" . $variasi . ")";
    }

?>

<div class="row">

    <!-- PRODUK -->
    <div class="produk">
        <img src="<?= $img ?>">
        <div class="nama-produk">
            <?= $namaFinal ?>
        </div>
    </div>

    <!-- HARGA -->
    <div>
        Rp<?= number_format($harga,0,',','.') ?>
    </div>

    <!-- QTY -->
    <div class="qty">
        <a class="btn" href="?aksi=kurang&id=<?= $id ?>">-</a>
        <span><?= $qty ?></span>
        <a class="btn" href="?aksi=tambah&id=<?= $id ?>">+</a>
    </div>

    <!-- SUBTOTAL -->
    <div>
        Rp<?= number_format($harga * $qty,0,',','.') ?>
    </div>

    <!-- HAPUS -->
    <div>
        <a class="btn" href="?aksi=hapus&id=<?= $id ?>">🗑</a>
    </div>

</div>

<?php } ?>

</div>

<!-- TOTAL -->
<div class="total-box">
    <div><b>Total Belanja</b></div>
    <div><b>Rp<?= number_format($total,0,',','.') ?></b></div>
    <a href="checkout.php" class="checkout">Checkout</a>
</div>

<a href="produk.php" class="kembali">Kembali</a>

</div>

</body>
</html>