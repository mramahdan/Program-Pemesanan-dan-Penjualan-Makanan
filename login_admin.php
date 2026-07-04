<?php
session_start();
include '../koneksi.php';

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $cek = mysqli_query($conn,"
        SELECT * FROM users 
        WHERE email='$user' 
        AND password='$pass' 
        AND role='admin'
    ");

    if(!$cek){
        die("Query error: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($cek);

    if($data){
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['role'] = 'admin';

        header("Location: dashboard_admin.php");
        exit;
    }else{
        echo "<script>alert('Login gagal');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Admin</title>
<style>
body{
    font-family:Segoe UI;
    background:#f5f5f5;
}

.box{
    width:350px;
    margin:100px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    text-align:center;
}

input{
    width:90%;
    padding:10px;
    margin:10px 0;
}

button{
    background:#f58220;
    color:white;
    border:none;
    padding:10px;
    width:100%;
}
</style>
</head>

<body>

<div class="box">
    <h2>Login Admin</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Masukkan Email" required>
        <input type="password" name="password" placeholder="Masukkan Password" required>
        <button name="login">Login</button>
    </form>
</div>

</body>
</html>