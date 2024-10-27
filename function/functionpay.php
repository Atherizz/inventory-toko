<?php 

require 'function.php';

function addCart ($data) {
    global $db;

    $produk = htmlspecialchars($data["product"]);
    $qty = htmlspecialchars($data["qty"]);

    // mengambil harga dari suatu produk
    $queryHarga = "SELECT harga FROM barang WHERE
    produk = '$produk'";

    $harga = mysqli_query($db, $queryHarga);
    $resultHarga = mysqli_fetch_assoc($harga);
    
    if(isset($resultHarga)) {
        $price = $resultHarga["harga"];
    } else {
        return 0;
    }

    // mencari id barang dari database barang
    $query = "SELECT id FROM barang WHERE
    produk = '$produk'";

    $barang = mysqli_query($db, $query);
    $result = mysqli_fetch_assoc($barang);

    if(isset($result)) {
    $idBarang = $result["id"];
    } else {
        return 0;
    }

    $query = "INSERT INTO detail_transaksi (id_barang, qty, harga, barang) VALUES
    ( '$idBarang', '$qty', '$price', '$produk' )
    ";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}



?>