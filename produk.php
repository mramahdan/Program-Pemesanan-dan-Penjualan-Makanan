<?php
include '../koneksi.php';

// TAMBAH
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "
    INSERT INTO produk (nama_produk,harga,stok)
    VALUES ('$nama','$harga','$stok')
    ");
}

// HAPUS
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk='".$_GET['hapus']."'");
}

$data = mysqli_query($conn, "SELECT * FROM produk");
?>

<h2>Kelola Produk</h2>

<form method="POST">
    <input type="text" name="nama" placeholder="Nama">
    <input type="number" name="harga" placeholder="Harga">
    <input type="number" name="stok" placeholder="Stok">
    <button name="tambah">Tambah</button>
</form>

<hr>

<?php while($p = mysqli_fetch_assoc($data)) { ?>
    <?= $p['nama_produk'] ?> - Rp<?= $p['harga'] ?>
    <a href="?hapus=<?= $p['id_produk'] ?>">Hapus</a><br>
<?php } ?>