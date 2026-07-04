<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$id     = $_GET['id'] ?? null;
$status = $_GET['status'] ?? null;

if(!$id || !$status){
    die("Data tidak lengkap");
}

/* 🔥 LOGIKA BARU */
if($status == 'dikirim'){
    // langsung jadi selesai
    mysqli_query($conn,"
    UPDATE pesanan 
    SET status_kirim='selesai'
    WHERE id_pesanan='$id'
    ");
}else{
    // default
    mysqli_query($conn,"
    UPDATE pesanan 
    SET status_kirim='$status'
    WHERE id_pesanan='$id'
    ");
}

/* kembali */
header("Location: pengiriman_admin.php");
exit;