<?php 
session_start();
if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT * FROM produk;"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanaktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanaktif) - $jumlahDataPerHalaman;
$produk = query("SELECT * FROM produk LIMIT $awalData, $jumlahDataPerHalaman;");

if (isset($_POST["refresh"])) {
    $produk = query("SELECT * FROM produk");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Daftar Produk</h1>
    <div class="menu">
        <div class="menu-box">
            <button><a href="logout.php" onclick="return confirm('Yakin?');">Logout</a></button>
        </div>
        <div class="menu-box">
            <button><a href="tambah.php">Tambah Data Produk</a></button>
        </div>
        <div class="menu-box">
            <button type="submit" name="refresh"><a href="index.php">Tampilkan Semua Produk</a></button>
        </div>
        <div class="menu-box">
            <input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencaharian" autocomplete="off" id="keyword">
            <form action="" method="post">
                <button type="submit" name="cari" id="tombol-cari">Cari!</button>
            </form>
        </div>
    </div>
    
    <br>

    <div id="container">
        <table border="1" cellpadding="1" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Gambar</th>
                <th>Harga</th>
                <th>Nama</th>
                <th>Warna</th>
                <th>Ukuran</th>
                <th>Aksi</th>
            </tr>
    
            <?php $i=1?>
            <?php foreach($produk as $prk): ?>
                <tr>
                    <td><?= $i+$awalData; ?></td>
                    <td><img src="<?= $prk["gambar"]; ?>" alt="" width="50"></td>
                    <td>Rp <?= $prk["harga"]; ?></td>
                    <td><?= $prk["name"]; ?></td>
                    <td><?= $prk["warna"]; ?></td>
                    <td><?= $prk["ukuran"]; ?></td>
                    <td>
                        <button><a href="ubah.php?id=<?= $prk["id"]; ?>">ubah</a></button> | <button><a href="hapus.php?id=<?= $prk["id"]; ?>" onclick="return confirm('Yakin?');">hapus</a></button> 
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
        
        <!-- pagination -->
        <div class="page">
            <div class="pages">
                <?php if ($halamanaktif > 1):?>
                    <a href="?page=<?= $halamanaktif-1; ?>">&le;</a>
                <?php endif; ?>
            </div>
            <?php if ($halamanaktif >= 3):?>
                <div class="pages"><a href="?page=1">1</a></div>
                <?php if ($halamanaktif != 3):?>
                    <div class="pages">...</div>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php for($i=$halamanaktif-1; $i<=$halamanaktif+1; $i++):?>
                <?php if ($i < 1 || $i > $jumlahHalaman): continue;?>
                <?php else: ?>
                    <div class="pages">
                        <?php if($i == $halamanaktif): ?>
                            <a href="?page=<?=$i; ?>" class="bold"><?=$i; ?></a>
                        <?php else: ?>
                            <a href="?page=<?=$i; ?>"><?=$i; ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($halamanaktif <= $jumlahHalaman - 2):?>
                <?php if ($halamanaktif != $jumlahHalaman - 2):?>
                    <div class="pages">...</div>
                <?php endif; ?>
                <div class="pages"><a href="?page=<?= $jumlahHalaman; ?>"><?= $jumlahHalaman; ?></a></div>
            <?php endif; ?>

            <div class="pages">
                <?php if ($halamanaktif < $jumlahHalaman):?>
                    <a href="?page=<?= $halamanaktif+1; ?>">&ge;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>