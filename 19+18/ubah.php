<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$id = $_GET["id"];
$prk = query("SELECT * FROM produk WHERE id = $id")[0];

if(isset($_POST["submit"])  ){
    if(ubah($_POST, $id) > 0) {
        echo "
            <script>
                alert('Data Berhasil Diubah!');
                document.location.href = 'index.php'
            </script>
        ";
    }
    else {
        echo " 
            <script>
                alert('Data Gagal Diubah!');
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
        <h1>Ubah Data Produk</h1>
        <input type="hidden" name="id" value="<?= $prk["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $prk["gambar"]; ?>">
        <div class="form">
            <div class="form-baris1">
                <div>
                    <label for="name">Name : </label>
                    <input type="text" name="name" id="name" required value="<?= $prk["name"]; ?>">               
                </div>
                <div>
                    <label for="harga">Harga : </label>
                    <input type="type" name="harga" id="harga" required value="<?= $prk["harga"]; ?>">
                </div>
            </div>
            <div class="form-baris2">
                <div>
                    <label for="warna">Warna : </label>
                    <input type="text" name="warna" id="warna" required value="<?= $prk["warna"]; ?>">
                </div>
                <div>
                    <label for="ukuran">Ukuran : </label>
                    <input type="text" name="ukuran" id="ukuran" required value="<?= $prk["ukuran"]; ?>">
                </div>
            </div>
            <div class="form-baris3">
                <label for="gambar">Gambar : </label>
                <img src="<?= $prk['gambar']; ?>" alt="" width="40"><br>
                <input type="file" name="gambar" id="gambar">
            </div>
            <div class="form-baris4">
                <div>
                    <button type="submit" name="submit">Ubah Data!</button>
                </div>
                <div>
                    <button><a href="index.php">Kembali kehalaman utama</a></button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>