<?php
session_start();

$id      = $_POST['id'] ?? '';
$nama    = $_POST['nama'] ?? '';
$harga   = $_POST['harga'] ?? 0;
$img     = $_POST['img'] ?? '';
$variasi = $_POST['variasi'] ?? ''; // ✅ semua pilihan masuk sini

if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = [];
}

// 🔥 fallback nama (biar aman kalau kosong)
if($nama == ''){
    $listMenu = [
        1 => "Bakso Bakar",
        2 => "Mie Level Pentol",
        3 => "Mie Level Biasa",
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
        19 => "Seblak pedas Komplite",
        20 => "Nasi Ayam Goreng"
    ];

    $nama = $listMenu[$id] ?? "Menu";
}

/*
🔥 SUPER PENTING:
Biar variasi beda jadi item berbeda
contoh:
- Pop Ice (Coklat)
- Pop Ice (Mangga)
- Mie Level (Level 3)
*/
$key = $id . '_' . $variasi;

// kalau produk sudah ada → tambah qty
if(isset($_SESSION['keranjang'][$key])){
    $_SESSION['keranjang'][$key]['qty']++;
}else{
    $_SESSION['keranjang'][$key] = [
        'id'       => $id,
        'nama'     => $nama,
        'harga'    => $harga,
        'img'      => $img,
        'qty'      => 1,
        'variasi'  => $variasi // ✅ simpan semua pilihan disini
    ];
}

header("Location: keranjang.php");
exit;