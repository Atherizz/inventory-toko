<?php 
session_start();
require 'function/function.php';

$error = "";

$id = $_SESSION["id"];

$query = "SELECT * FROM user WHERE id = '$id'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);

// memeriksa apakah benar gambar / bukan
if (isset($_POST["submit"])) {

    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["profile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profile"] ["tmp_name"]);

    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image!";
        $uploadOk = 0;
    }

    // // memeriksa apakah file sudah ada
    // if (file_exists($target_file)) {
    //     $error = "file already exist!";
    //     $uploadOk = 0;
    // }

    if ($_FILES["profile"]["size"] > 50000000) {
        $error =  "sorry, your file is too large!";
        $uploadOk = 0;
    } 

    // apakah format file sudah benar
    if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
        $error = "only jpg, png, & jpeg are allowed!";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {

    } else {
        if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
    
            $username = $user["username"];
            $name = $_POST["name"];
            $email = $_POST["email"];

            $queryAdd = "UPDATE user 
            SET
            nickname = '$name',
            email = '$email',
            `image` = '$target_file'
            WHERE username = '$username'
            ";
            mysqli_query($db, $queryAdd);
            echo "<script>
            alert('profile berhasil diupdate!')
            </script>";
            header("Location: home.php");
                
            } else {
            $error = "there was an error while uploading!";
        }
    }
    
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalesHub - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-blue-50 font-sans">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white h-screen shadow-md">
            <div class="flex items-center justify-center h-16 border-b">
                <div class="text-xl font-bold">SalesHub</div>
            </div>
            <div class="p-4">
                <ul>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="index.php">
                        <i class="fas fa-home w-6"></i>
                        <span class="ml-2"> Home </span>
                    </a>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="inventory.php">
                        <i class="fas fa-box w-6"></i>
                        <span class="ml-2"> Inventory </span>
                    </a>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="order.php">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span class="ml-2"> Sales Report </span>
                    </a>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="report.php">
                        <i class="fas fa-users w-6"></i>
                        <span class="ml-2"> Customer Report</span>
                    </a>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="customer.php">
                        <i class="fas fa-chart-line w-6"></i>
                        <span class="ml-2"> Customer </span>
                    </a>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="cashier.php">
                        <i class="fas fa-file-alt w-6"></i>
                        <span class="ml-2"> Cashier </span>
                    </a>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="settings.php">
                        <i class="fas fa-cog w-6"></i>
                        <span class="ml-2"> Settings </span>
                    </a>
                    <a class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="profile.php">
                        <i class="fas fa-user w-6"></i>
                        <span class="ml-2"> Profile </span>
                    </a>
                </ul>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h2 class="text-2xl font-bold mb-4">Profile</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4">Data Diri</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700">Username Akun:</label>
                    <input type="text" class="mt-1 block w-full p-2 border rounded" name="username" value="<?= $user["username"] ?>" disabled>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Nama:</label>
                    <input type="text" class="mt-1 block w-full p-2 border rounded" name="name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email:</label>
                    <input type="email" class="mt-1 block w-full p-2 border rounded" name="email" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Foto Profil:</label>
                    <input type="file" class="mt-1 block w-full p-2 border rounded" name="profile" required>
                </div>
                <p style="color: red; font-style:italic;"><?= $error ?></p>
                <div class="flex justify-end">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" name="submit">
                Submit
                </button>
                </div>
                    </form>
