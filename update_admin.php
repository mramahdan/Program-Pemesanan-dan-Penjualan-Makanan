<?php
include '../koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($conn,"
UPDATE pesanan SET status='$status'
WHERE id_pesanan='$id'
");

header("Location: detail_pesanan_admin.php?id=$id");