<?php
session_start();
include '../koneksi.php';

// proteksi admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$data = mysqli_query($conn,"SELECT * FROM users WHERE role='pelanggan'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Pelanggan</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

/* LAYOUT */
.container{
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    background:#f58220;
    color:white;
    min-height:100vh;
    padding:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    margin:10px 0;
    padding:10px;
    border-radius:6px;
}

.sidebar a:hover{
    background:white;
    color:#f58220;
}

/* CONTENT */
.content{
    flex:1;
    padding:30px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
}

th{
    background:#f58220;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#f9f9f9;
}

h2{
    margin-bottom:20px;
}
</style>
</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard_admin.php">Dashboard</a>
    <a href="pesanan_admin.php">Pesanan</a>
    <a href="produk_admin.php">Produk</a>
    <a href="pelanggan_admin.php">Pelanggan</a>

    <a href="pengiriman_admin.php">Pengiriman</a>
    
    <a href="../logout.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<h2>Data Pelanggan</h2>

<table>
<tr>
    <th>Nama</th>
    <th>Email</th>
</tr>

<?php while($u=mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $u['nama'] ?></td>
    <td><?= $u['email'] ?? '-' ?></td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>
