<?php
session_start();

$order = $_SESSION['order'] ?? null;

if(!$order){
    header("Location: produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Pesanan Berhasil</title>

<style>

body{
    font-family:'Segoe UI';
    text-align:center;
    padding-top:100px;
}

h1{
    color:green;
}

.btn{
    background:#f58220;
    color:white;
    padding:12px 20px;
    border-radius:8px;
    text-decoration:none;
}

</style>
</head>
<body>

<h1>✅ Pesanan Berhasil Dibuat</h1>

<p>
Metode Pembayaran:
<strong><?= $order['pembayaran']; ?></strong>
</p>

<p>
Terima kasih telah memesan di Fondies.
</p>

<br>

<a href="produk.php" class="btn">
Kembali ke Menu
</a>

</body>
</html>