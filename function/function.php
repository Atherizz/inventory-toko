<?php 

$db = mysqli_connect("localhost", "root", "", "belajarphp");

function query ($query) {
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// function tambahProfil($data) {
//     global $db;

//     $name = htmlspecialchars($data["name"]);
//     $email = htmlspecialchars($data["email"]);
//     $image = upload();

//     $query = "INSERT INTO user (nickname, email, `image`) VALUES
//     ('$name', '$email', '$image')
//     ";

//     mysqli_query($db, $query);

//     return mysqli_affected_rows($db);
    
// }

// function upload () {
//     global $db;

//     $namaFile = $_FILES['image']['']

    
// }

function tambah ($data) {
    global $db;

    $produk = htmlspecialchars($data["produk"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga = htmlspecialchars($data["harga"]);
    $stock = htmlspecialchars($data["stock"]);

    $query = "INSERT INTO barang (produk,kategori,harga,stock) VALUES
    ('$produk','$kategori','$harga', '$stock')
    ";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function edit ($data) {
    global $db;
    $id = $data["id"];

    $produk = htmlspecialchars($data["produk"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga = htmlspecialchars($data["harga"]);
    $stock = htmlspecialchars($data["stock"]);

    $query = "UPDATE barang 
    SET
    produk = '$produk',
    kategori = '$kategori',
    harga = '$harga',
    stock = '$stock'
    WHERE id = '$id'
    ";

mysqli_query($db, $query);
return mysqli_affected_rows($db);
}

function delete ($id) {
    global $db; 

    $query = "DELETE FROM barang WHERE
    id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function cari ($keyword) {
    global $db;

    $query = "SELECT * FROM produk WHERE
    produk LIKE '%$keyword%' OR
    kategori LIKE '%$keyword%'
    ";

    return $query;
}

function register($data) {
    global $db;

    $username = strtolower($data["username"]);
    $password = mysqli_real_escape_string($db,$data["password"] );
    $password2 = mysqli_real_escape_string($db,$data["password2"] );

    $query = "SELECT username FROM user WHERE
    username = '$username'
    ";

    $result = mysqli_query($db, $query);

    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>alert('maaf username telah digunakan!')
        </script>";
        return false;
    }

    if ($password !== $password2) {
        echo "
        <script>alert('konfirmasi password harus sama!')
        </script>";
        return false;

    } 

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (username,password) VALUES
    ('$username','$password')
    ";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);

    
}

?>