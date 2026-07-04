<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id_user'])) die("login dulu");
if(empty($_SESSION['keranjang'])) die("keranjang kosong");

$id_user = $_SESSION['id_user'];
$metode  = $_POST['pembayaran'] ?? '';

// 🔥 HITUNG TOTAL
$total = 0;

foreach($_SESSION['keranjang'] as $item){
    $harga = $item['harga'] ?? 0;
    $qty   = $item['qty'] ?? 0;
    $total += $harga * $qty;
}

$ongkir = 5000;
$total  = $total + $ongkir;

// 🔥 SIMPAN KE TABEL PESANAN
mysqli_query($conn,"
INSERT INTO pesanan(id_user,total,ongkir,metode_bayar,status,status_kirim)
VALUES('$id_user','$total','$ongkir','$metode','diproses','diproses')
");

$id_pesanan = mysqli_insert_id($conn);

// 🔥 LIST MENU (ANTI NAMA JADI "MENU")
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

// 🔥 SIMPAN DETAIL + KURANGI STOK
foreach($_SESSION['keranjang'] as $item){

    $id_produk = $item['id'];
    $nama      = $item['nama'];
    $variasi   = $item['variasi'] ?? '';
    $harga     = $item['harga'];
    $qty       = $item['qty'];
    $subtotal  = $harga * $qty;

    // 🔥 CEK STOK
    $cek = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT stok FROM produk WHERE id_produk='$id_produk'
    "));

    if($cek['stok'] < $qty){
        die("Stok tidak cukup untuk $nama");
    }

    // 🔥 KURANGI STOK
    mysqli_query($conn,"
        UPDATE produk 
        SET stok = stok - $qty 
        WHERE id_produk='$id_produk'
    ");

    // 🔥 SIMPAN DETAIL
    mysqli_query($conn,"
    INSERT INTO detail_pesanan
    (id_pesanan,id_produk,nama_produk,variasi,jumlah,harga,subtotal)
    VALUES
    ('$id_pesanan','$id_produk','$nama','$variasi','$qty','$harga','$subtotal')
    ");
}

// 🔥 KOSONGKAN KERANJANG
unset($_SESSION['keranjang']);

// 🔥 REDIRECT
header("Location: detail_pesanan.php?id=$id_pesanan");
exit;