<?php
session_start();
include 'koneksi.php';

/* =========================
   VALIDASI ID PESANAN
========================= */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID pesanan tidak ditemukan");
}

$id_pesanan = (int)$_GET['id'];

/* =========================
   AMBIL DATA PESANAN
========================= */
$qPesanan = mysqli_query($conn,"
    SELECT * FROM pesanan
    WHERE id_pesanan='$id_pesanan'
");

$pesanan = mysqli_fetch_assoc($qPesanan);

if(!$pesanan){
    die("Pesanan tidak ditemukan");
}

$metode = $pesanan['metode_bayar'] ?? '';

/* =========================
   PROSES BAYAR
========================= */
if(isset($_POST['bayar'])){

    $tipe = $_POST['tipe'];

    $id_user = $_SESSION['id_user'] ?? 0;

    if(!$id_user){
        die("Session login tidak ditemukan");
    }

    $bank = '';
    $rekening = '';
    $nama = '';
    $status = 'selesai';

    if($tipe == 'COD'){

        $bank = 'COD';
        $rekening = '-';
        $nama = 'Pelanggan';

    }elseif($tipe == 'TRANSFER'){

        $bank = $_POST['bank'] ?? '';
        $rekening = $_POST['rekening'] ?? '';
        $nama = $_POST['nama'] ?? '';

    }elseif($tipe == 'EWALLET'){

        $bank = $_POST['bank'] ?? '';
        $rekening = $_POST['rekening'] ?? '';
        $nama = $_POST['nama'] ?? '';
    }

    /* =========================
       INSERT PEMBAYARAN
    ========================= */
    $insert = mysqli_query($conn,"
        INSERT INTO pembayaran
        (
            id_pesanan,
            id_user,
            bank,
            no_rekening,
            nama_pengirim,
            status
        )
        VALUES
        (
            '$id_pesanan',
            '$id_user',
            '$bank',
            '$rekening',
            '$nama',
            '$status'
        )
    ");

    if(!$insert){
        die("Gagal menyimpan pembayaran : ".mysqli_error($conn));
    }

    /* =========================
       UPDATE STATUS PESANAN
    ========================= */
    mysqli_query($conn,"
        UPDATE pesanan
        SET status='selesai'
        WHERE id_pesanan='$id_pesanan'
    ");

    header("Location: konfirmasi_pembayaran.php?id=".$id_pesanan);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Pembayaran</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
}

.container{
    width:650px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

.header{
    background:#f58220;
    color:#fff;
    text-align:center;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

input,
select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:8px;
}

.btn{
    background:#f58220;
    color:#fff;
    padding:12px;
    border:none;
    width:100%;
    border-radius:8px;
    cursor:pointer;
}

.card{
    background:#f9f9f9;
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
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

.back:hover{
    background:#ccc;
}

</style>
</head>

<body>

<div class="container">

<a href="ubah_pembayaran.php?id=<?= $id_pesanan ?>" class="back">
    ← Ganti Metode Pembayaran
</a>

<div class="header">
    <h2>Pembayaran Pesanan</h2>
    <p>
        Total :
        Rp <?= number_format($pesanan['total'] ?? 0,0,',','.') ?>
    </p>
</div>

<?php if($metode == 'COD'){ ?>

<div class="card">
    <h3>Cash On Delivery (COD)</h3>
    <p>Bayar saat pesanan diterima.</p>
</div>

<form method="POST">

    <input type="hidden" name="tipe" value="COD">

    <button type="submit" name="bayar" class="btn">
        Konfirmasi COD
    </button>

</form>

<?php } ?>

<?php if($metode == 'Transfer Bank'){ ?>

<div class="card">
    <h3>Transfer Bank</h3>
</div>

<form method="POST">

    <input type="hidden" name="tipe" value="TRANSFER">

    <select name="bank" required>
        <option value="">Pilih Bank</option>
        <option>BCA</option>
        <option>BRI</option>
        <option>BNI</option>
        <option>MANDIRI</option>
    </select>

    <input
        type="text"
        name="rekening"
        placeholder="No Rekening"
        required
    >

    <input
        type="text"
        name="nama"
        placeholder="Nama Pengirim"
        required
    >

    <button type="submit" name="bayar" class="btn">
        Konfirmasi Pembayaran
    </button>

</form>

<?php } ?>

<?php if($metode == 'E-Wallet'){ ?>

<div class="card">
    <h3>E-Wallet</h3>
</div>

<form method="POST">

    <input type="hidden" name="tipe" value="EWALLET">

    <select name="bank" required>
        <option value="">Pilih E-Wallet</option>
        <option>DANA</option>
        <option>OVO</option>
        <option>GOPAY</option>
        <option>SHOPEEPAY</option>
    </select>

    <input
        type="text"
        name="rekening"
        placeholder="Nomor HP"
        required
    >

    <input
        type="text"
        name="nama"
        placeholder="Nama Pemilik"
        required
    >

    <button type="submit" name="bayar" class="btn">
        Konfirmasi Pembayaran
    </button>

</form>

<?php } ?>

</div>

</body>
</html>