<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
if(isset($_POST["submit"])){
    // cek data berhasil ditambah atau tidak
    if(tambah($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Ditambahkan!');
                document.location.href = 'index.php'
            </script>
        ";
    }
    else {
        echo " 
            <script>
                alert('Data Gagal Ditambahkan!');
                document.location.href = 'index.php'
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Tambah Data Produk</h1>
        <div class="form">
            <div class="form-baris1">
                <div>
                    <label for="name">Name : </label>
                    <input type="text" name="name" id="name" required>               
                </div>
                <div>
                    <label for="harga">Harga : </label>
                    <input type="text" name="harga" id="harga" required>
                </div>
            </div>
            <div class="form-baris2">
                <div>
                    <label for="warna">Warna : </label>
                    <input type="text" name="warna" id="warna" required>
                </div>
                <div>
                    <label for="ukuran">Ukuran : </label>
                    <input type="text" name="ukuran" id="ukuran" required>
                </div>
            </div>
            <div class="form-baris3">
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar" required>
            </div>
            <div class="form-baris4">
                <div>
                    <button type="submit" name="submit">Tambah Data!</button>
                </div>
                <div>
                    <button><a href="index.php">Kembali kehalaman utama</a></button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>