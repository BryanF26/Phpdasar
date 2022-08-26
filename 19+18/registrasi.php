<?php
require 'functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "
            <script>
                alert('User baru berhasil Ditambahkan!');
            </script>
        ";
    }
    else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="post">
        <h1>Halaman Registrasi</h1>
        <div class="form">
            <div class="form-baris1">
                <label for="username">username : </label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-baris2">
                <label for="password">password : </label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-baris3">
                <label for="password2">konfirmasi password : </label>
                <input type="password" name="password2" id="password2" required>
            </div>
            <div class="form-baris4">
                <div>
                    <button type="submit" name="register">Register!</button>
                </div>
                <div>
                    <button><a href="login.php">Login</a></button>
                </div>
            </div>
        </div>
    </form>

</body>
</html>