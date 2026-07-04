<?php
include '../koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM produk WHERE id_produk='$id'
"));

if(isset($_POST['update'])){
    mysqli_query($conn,"
    UPDATE produk SET 
    nama_produk='$_POST[nama]',
    harga='$_POST[harga]',
    stok='$_POST[stok]'
    WHERE id_produk='$id'
    ");

    header("Location: produk_admin.php");
}
?>

<form method="POST">
    Nama <br>
    <input type="text" name="nama" value="<?= $data['nama_produk'] ?>"><br><br>

    Harga <br>
    <input type="number" name="harga" value="<?= $data['harga'] ?>"><br><br>

    Stok <br>
    <input type="number" name="stok" value="<?= $data['stok'] ?>"><br><br>

    <button name="update">Update</button>
</form>