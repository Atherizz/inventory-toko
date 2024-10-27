<?php 

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'function/function.php';

$id = $_GET["id"];

$barang = query("SELECT * FROM barang WHERE id = $id")[0];

if (isset($_POST["submit"])) {
    if (edit($_POST) > 0) {
         echo "<script>
    document.location.href = 'index.php'
    </script>";
    }
}

?>
    

<html>
  <head>
    <title>SalesHub - Add Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Inter", sans-serif;
      }
    </style>
  </head>
  <body class="bg-blue-100">
    <div class="flex h-screen">
      <!-- Sidebar -->
      <div class="w-1/5 bg-white p-6 shadow-lg">
        <div class="flex items-center mb-8">
          <div class="w-8 h-8 bg-blue-500 rounded-full mr-3"></div>
          <span class="text-xl font-semibold"> SalesHub </span>
        </div>
        <nav>
          <ul>
            <li class="mb-4">
              <a class="flex items-center text-blue-500" href="#">
                <i class="fas fa-home mr-3"> </i>
                Home
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-blue-500" href="#">
                <i class="fas fa-box mr-3"> </i>
                Inventory
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-shopping-cart mr-3"> </i>
                Orders
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-users mr-3"> </i>
                Customer Report
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-chart-line mr-3"> </i>
                Revenue
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-chart-pie mr-3"> </i>
                Growth
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-file-alt mr-3"> </i>
                Cashier
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-cog mr-3"> </i>
                Settings
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <!-- Main Content -->
      <div class="flex-1 p-6">
        <div class="flex justify-between items-center mb-6">
          <div
            class="flex items-center bg-white p-2 rounded-lg shadow-md w-1/2"
          >
            <i class="fas fa-search text-gray-400 mr-2"> </i>
            <input
              class="w-full border-none focus:outline-none"
              placeholder="Search"
              type="text"
            />
          </div>
          <div class="flex items-center">
            <div class="bg-white p-2 rounded-lg shadow-md mr-4">
              <select class="border-none focus:outline-none">
                <option>Last 7 days</option>
                <option>Last 30 days</option>
                <option>Last 90 days</option>
              </select>
            </div>
            <div class="flex items-center">
              <div class="w-8 h-8 bg-gray-300 rounded-full mr-2"></div>
              <span> John Doe </span>
            </div>
          </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-xl font-semibold mb-4">Edit Item</h2>

          <form method="POST" action="">
            <div class="mb-4">
            <input
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                id="product-name" name="id" value="<?= $barang["id"] ?>"
                type="hidden"
              />
              <label class="block text-gray-700 mb-2" for="product-name">
                Product Name
              </label>
              <input
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                id="product-name" name="produk" value="<?= $barang["produk"] ?>"
                type="text"
              />
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 mb-2" for="category">
                Category
              </label>
              <select class="border-none focus:outline-none" name="kategori" value="<?= $barang["kategori"] ?>">
                <option>makanan & minuman</option>
                <option>kesehatan</option>
                <option>kecantikan</option>
                <option>peralatan rumah tangga</option>
                <option>kebutuhan pokok</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 mb-2" for="price">
                Price
              </label>
              <input
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                id="price" name="harga"
                type="text" value="<?= $barang["harga"] ?>"
              />
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 mb-2" for="stock">
                Stock
              </label>
              <input
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                id="stock" name="stock"
                type="text" value="<?= $barang["stock"] ?>"
              />
            </div>
            <div class="flex justify-end">
              <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" name="submit">
                Edit Item
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
