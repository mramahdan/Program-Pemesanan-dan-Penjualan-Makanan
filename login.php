<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn,"
        SELECT *
        FROM users
        WHERE email='$email'
        AND password='$password'
    ");

    $user = mysqli_fetch_assoc($query);

    if ($user) {

        // SIMPAN SEMUA DATA KE SESSION
        $_SESSION['user'] = $user;

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // ✅ TAMBAHAN PENTING (INI YANG KAMU BUTUH)
        $_SESSION['telepon'] = $user['telepon'];
        $_SESSION['alamat']  = $user['alamat'];

        if ($user['role'] == 'admin') {

            header("Location: admin/dashboard_admin.php");
            exit;

        } else {

            header("Location: dashboard.php");
            exit;

        }

    } else {

        echo "<script>
                alert('Email atau Password salah!');
              </script>";

    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>

<style>

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f58220;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    background:#fff;
    width:350px;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
}

h1{
    text-align:center;
    margin-bottom:25px;
    color:#f58220;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
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

<div class="login-box">

<h1>Login</h1>

<form method="POST">

    <input
        type="email"
        name="email"
        placeholder="Masukkan Email"
        required>

    <input
        type="password"
        name="password"
        placeholder="Masukkan Password"
        required>

    <button type="submit" name="login">
        Login
    </button>

</form>

<p>
    Belum punya akun?
    <a href="register.php">Daftar</a>
</p>

</div>

</body>
</html>
