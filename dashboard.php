<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Beranda</title>

<style>

body{
    margin:0;
    font-family:'Segoe UI';
    background:#f5f5f5;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 30px;
    background:white;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}

.logo{
    color:#f58220;
    font-weight:bold;
    font-size:22px;
}

.menu a{
    margin:0 10px;
    text-decoration:none;
    color:#333;
    font-size:14px;
}

.menu a:hover{
    color:#f58220;
}

.right{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:14px;
}

.btn{
    background:#f58220;
    color:white;
    padding:6px 12px;
    border-radius:8px;
    text-decoration:none;
}

/* HERO */
.hero{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:60px 70px;
    background:#fff;
    margin:20px;
    border-radius:15px;
    min-height:340px;
}

.hero-text{
    max-width:520px;
}

.hero-text h1{
    font-size:28px;
    margin-bottom:10px;
    line-height:1.4;
}

.hero-text p{
    color:gray;
}

.btn-pesan{
    display:inline-block;
    margin-top:15px;
    background:#f58220;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
}

/* GAMBAR HERO (FIX LEBIH BESAR & RAPI) */
.hero img{
    width:380px;
    max-width:100%;
    margin-left:-20px;
    transition:0.3s;
}

/* KATEGORI */
.kategori{
    padding:15px 40px 30px 40px;
    margin-top:-5px;
}

.kategori-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.lihat{
    color:#f58220;
    text-decoration:none;
    font-weight:bold;
}

/* GRID KATEGORI */
.kategori-box{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(120px, 1fr));
    gap:15px;
}

.box{
    background:#fff;
    border-radius:15px;
    padding:20px;
    text-align:center;
    font-size:30px;
    cursor:pointer;
    transition:0.2s;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}

.box:hover{
    transform:translateY(-3px);
    background:#fff3ea;
}

.kategori-box a{
    text-decoration:none;
    color:black;
}

.user{
    color:#333;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

    <div class="logo">Fondies</div>

    <div class="menu">
        <a href="#">Beranda</a>
        <a href="produk.php">Menu</a>
        <a href="#">Cara Pemesanan</a>
        <a href="#">Tentang Kami</a>
    </div>

    <div class="right">
        🔍 🛒
        <span class="user">
            <?= $_SESSION['user']['nama']; ?>
        </span>
        <a href="logout.php" class="btn">Logout</a>
    </div>

</div>

<!-- HERO -->
<div class="hero">

    <div class="hero-text">
        <h1>
            Nikmati Makanan Lezat<br>
            Kapan Saja,<br>
            Di Mana Saja
        </h1>
        <p>Pesan makanan favoritmu dengan cepat dan mudah.</p>
        <a href="produk.php?kategori=semua" class="btn-pesan">
            Pesan Sekarang
        </a>
    </div>

    <img src="https://thfvnext.bing.com/th/id/OIP.sW94pSDU0YqRv_t443iCBgHaF6?w=271&h=218&c=7&r=0&o=7&cb=thfvnextfalcon2&dpr=1.5&pid=1.7&rm=3"
     style="width:450px; max-width:100%; margin-left:-20px;">

</div>

<!-- KATEGORI -->
<div class="kategori">

    <div class="kategori-header">
        <h3>Kategori Menu</h3>
        <a href="produk.php?kategori=semua" class="lihat">Lihat Semua</a>
    </div>

    <div class="kategori-box">

        <a href="produk.php?kategori=makanan">
            <div class="box">🍜</div>
        </a>

        <a href="produk.php?kategori=minuman">
            <div class="box">🥤</div>
        </a>

    </div>

</div>

</body>
</html>