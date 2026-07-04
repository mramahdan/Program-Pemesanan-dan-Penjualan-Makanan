<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$id = $_POST['id'];
$tambah = (int)$_POST['tambah'];

// 🔥 DEBUG (hapus nanti kalau sudah jalan)
// echo "ID: $id | Tambah: $tambah"; exit;

// 🔥 UPDATE STOK
mysqli_query($conn,"
UPDATE produk 
SET stok = stok + $tambah
WHERE id_produk='$id'
");

// 🔥 CEK QUERY ERROR
if(mysqli_error($conn)){
    die("Error: " . mysqli_error($conn));
}

header("Location: produk_admin.php");
exit;