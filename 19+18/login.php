<?php
session_start();
require 'functions.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row["username"])) {
        $_SESSION["login"] = true;
    }
}
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

        // cek username
        if (mysqli_num_rows($result) === 1) {
            // cek password
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password,$row["password"])) {
                // set session
                $_SESSION["login"] = true;

                // cek remember me
                if(isset($_POST["remember"])) {
                    // buat cookie username
                    setcookie('key', hash('sha256',$row['username']), time()+60);
                    // cookie id
                    setcookie('id', $row["id"], time()+60);
                }
                header("Location: index.php");
                exit;
            }
        }
        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Halaman Login</h1>

    <?php if(isset($error)) : ?>
        <p style="color: pink; font-style: italic;">username / password salah!</p>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form">
            <div class="form-baris1">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-baris2">
                <label for="password">Password : </label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-baris3">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </div>
            <div class="form-baris4">
                <div>
                    <button type="submit" name="login">Login</button>
                </div>
                <div>
                    <button><a href="registrasi.php">Register</a></button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>