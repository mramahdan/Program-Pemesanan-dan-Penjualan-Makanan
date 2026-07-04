<?php
session_start();

$id = $_GET['id'];
$aksi = $_GET['aksi'];

if(isset($_SESSION['keranjang'][$id])){

    if($aksi == "plus"){
        $_SESSION['keranjang'][$id]['qty']++;
    }

    if($aksi == "minus"){

        $_SESSION['keranjang'][$id]['qty']--;

        if($_SESSION['keranjang'][$id]['qty'] <= 0){
            unset($_SESSION['keranjang'][$id]);
        }
    }
}

header("Location: keranjang.php");
exit;
?>