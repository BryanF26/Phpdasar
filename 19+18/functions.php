<?php
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah ($data) {
    global $conn;
    $name = htmlspecialchars($data["name"]);
    $harga = htmlspecialchars($data["harga"]);
    $warna = htmlspecialchars($data["warna"]);
    $ukuran = htmlspecialchars($data["ukuran"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO produk VALUES('','$name',$harga,'$warna','$ukuran','$gambar')";
     
    mysqli_query($conn, $query);
     
    return mysqli_affected_rows($conn);
}

function hapus($id) {
    global $conn;
    $file = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM produk WHERE id='$id'"));
    unlink($file["gambar"]);
    mysqli_query($conn, "DELETE FROM produk WHERE id = $id;");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    $id = $data["id"];
    $name = htmlspecialchars($data["name"]);
    $harga = htmlspecialchars($data["harga"]);
    $warna = htmlspecialchars($data["warna"]);
    $ukuran = htmlspecialchars($data["ukuran"]);
    $gambarLama = $data["gambarLama"];

    // cek apakah user upload gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    }
    else {
        $gambar = upload();
    }

    $query = "UPDATE produk SET
        name = '$name',
        harga = $harga,
        warna = '$warna',
        ukuran = '$ukuran',
        gambar = '$gambar' 
        WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari ($keyword) {
    $query = "SELECT * FROM produk WHERE 
    name LIKE '%$keyword%' OR 
    harga LIKE '%$keyword%' OR 
    warna LIKE '%$keyword%' OR
    ukuran LIKE '%$keyword%'
    ";
    return query($query);
}

function upload () {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "
            <script>
                alert('pilih gambar terlebih dahulu!');
            </script>
        ";
        return false;
    }

    // cek yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    // explode(delimeter, string);
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert('Yang anda upload bukan gambar!');
            </script>
        ";
        return false;   
    }
    
    // cek jika ukuran gambar terlalu besar
    if ($ukuranFile > 1000000) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar!');
            </script>
        ";
        return false;
    }

    // generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru.= '.';
    $namaFileBaru.= $ekstensiGambar;
    $namaFileBaru = 'Foto/'.$namaFileBaru;
    // gambar siap diupload
    move_uploaded_file($tmpName, $namaFileBaru);
    return $namaFileBaru;

}

function registrasi ($data) {
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $password2 = mysqli_real_escape_string($conn,$data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo "
            <script>
                alert('username yang dipilih sudah terdaftar!');
            </script>
        ";
        return false;
    }

    // cek password sama
    if ($password != $password2) {
        echo "
                <script>
                    alert('Konfirmasi password tidak sesuai!');
                </script>
            ";
        return false;
    }
    
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}
?>