<?php
session_start();
include '../koneksi.php';

// proteksi admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

// ambil data pesanan
$data = mysqli_query($conn,"
SELECT p.*, u.nama 
FROM pesanan p
JOIN users u ON p.id_user = u.id_user
ORDER BY p.id_pesanan DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Pengiriman</title>

<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
    margin:0;
}

.container{
    width:90%;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
    margin-top:20px;
}

h2{
    margin-bottom:20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

th{
    background:#f58220;
    color:white;
}

/* STATUS BADGE */
.badge{
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
    font-weight:bold;
}

.diproses{ background:#fbc02d; }
.dikirim{ background:#2196f3; }
.selesai{ background:#4caf50; }

/* BUTTON */
.btn{
    padding:6px 12px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:12px;
}

.kirim{ background:#2196f3; }
.selesai-btn{ background:#4caf50; }

.back{
    display:inline-block;
    margin-bottom:15px;
    background:#6c757d;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="container">

<a href="dashboard_admin.php" class="back">← Kembali</a>

<h2>Data Pengiriman</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

<?php while($p = mysqli_fetch_assoc($data)){ 

    $status = strtolower($p['status_kirim'] ?? 'diproses');

?>

<tr>
    <td>#<?= $p['id_pesanan'] ?></td>
    <td><?= $p['nama'] ?></td>

    <!-- STATUS -->
    <td>
        <?php if($status == 'diproses'){ ?>
            <span class="badge diproses">Diproses</span>

        <?php } elseif($status == 'dikirim'){ ?>
            <span class="badge dikirim">Dikirim</span>

        <?php } else { ?>
            <span class="badge selesai">Selesai</span>
        <?php } ?>
    </td>

    <!-- AKSI -->
    <td>
        <?php if($status == 'diproses'){ ?>
            <a href="update_status.php?id=<?= $p['id_pesanan'] ?>&status=dikirim"
            class="btn kirim">
            Kirim
            </a>
        <?php } else { ?>
            <span style="color:#999;">-</span>
        <?php } ?>
    </td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>