<?php
require '../functions.php';

$jumlahDataPerHalaman = 5;
$produk = cari($_GET["keyword"]);
$jumlahData = count($produk);
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanaktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanaktif) - $jumlahDataPerHalaman;
$produk = array_slice($produk,$awalData,$jumlahDataPerHalaman);
?>

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
            <td><?= $i; ?></td>
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