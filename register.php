<?php
session_start(); // WAJIB untuk session
include 'koneksi.php';

if (isset($_POST['daftar'])) {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];

    // cek password sama
    if ($password != $confirm) {
        echo "<script>alert('Password tidak sama!');</script>";
    } else {

        // cek email sudah ada
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
        } else {

            // SIMPAN KE DATABASE (DITAMBAH TELEPON & ALAMAT)
            mysqli_query($conn, "
                INSERT INTO users 
                (nama, email, password, telepon, alamat, role)
                VALUES
                ('$nama', '$email', '$password', '$telepon', '$alamat', 'pelanggan')
            ");

            // SIMPAN KE SESSION (INI YANG PENTING UNTUK CHECKOUT)
            $_SESSION['user'] = [
                "nama" => $nama,
                "telepon" => $telepon,
                "alamat" => $alamat,
                "email" => $email
            ];

            echo "<script>alert('Berhasil daftar!'); window.location='login.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar</title>

    <style>

    body{
        margin:0;
        font-family:'Segoe UI', sans-serif;
        background:#f58220;
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
    }

    .box{
        background:#fff;
        width:380px;
        padding:30px;
        border-radius:12px;
        box-shadow:0 4px 10px rgba(0,0,0,0.2);
    }

    h1{
        text-align:center;
        color:#f58220;
        margin-bottom:20px;
    }

    input, textarea{
        width:100%;
        padding:12px;
        margin-bottom:12px;
        border:1px solid #ccc;
        border-radius:8px;
        box-sizing:border-box;
        font-family:'Segoe UI';
    }

    textarea{
        resize:none;
        height:70px;
    }

    button{
        width:100%;
        padding:12px;
        border:none;
        background:#f58220;
        color:white;
        font-size:16px;
        border-radius:8px;
        cursor:pointer;
    }

    button:hover{
        background:#e06f0f;
    }

    p{
        text-align:center;
        margin-top:15px;
    }

    a{
        color:#f58220;
        text-decoration:none;
        font-weight:bold;
    }

    </style>
</head>
<body>

<div class="box">

    <h1>Daftar</h1>

    <form method="POST">

        <input type="text" name="nama" placeholder="Nama Lengkap" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="text" name="telepon" placeholder="Nomor Telepon" required>

        <textarea name="alamat" placeholder="Alamat Lengkap" required></textarea>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>

        <button type="submit" name="daftar">
            Daftar
        </button>

    </form>

    <p>
        Sudah punya akun?
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>