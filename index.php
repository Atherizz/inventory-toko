<?php 
require 'function/function.php';

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$barisPerHalaman = 12;
$jumlahData = count(query("SELECT * FROM barang"));
$jumlahHalaman = ceil($jumlahData / $barisPerHalaman);
if (isset($_GET["page"])) {
  $halamanAktif = $_GET["page"];
} else {
  $halamanAktif = 1;
}

$awalData = ($halamanAktif * $barisPerHalaman) - $barisPerHalaman;

$barang = query("SELECT * FROM barang LIMIT $awalData, $barisPerHalaman");

// $queryStock = mysqli_query($db, "SELECT stock FROM barang");
$jumlahStock = 0;

foreach($barang as $stock) {
  $jumlahStock+=$stock["stock"];
}

$totalProduk = mysqli_query($db, "SELECT * FROM barang");



$orderan = query("SELECT * FROM riwayat_transaksi");

$stokTerjual = 0;

foreach($orderan as $terjual) {
  $stokTerjual+=$terjual["qty"];
}
?>

<html>
  <head>
    <title>SalesHub Dashboard</title>
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
              <a class="flex items-center text-gray-500" href="home.php">
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
              <a class="flex items-center text-gray-600" href="order.php">
                <i class="fas fa-shopping-cart mr-3"> </i>
                Sales Report
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="report.php">
                <i class="fas fa-users mr-3"> </i>
                Customer Report
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="customer.php">
                <i class="fas fa-chart-line mr-3"> </i>
                Customer
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-chart-pie mr-3"> </i>
                Growth
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="cashier.php">
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
              type="text" name="keyword" id="keyword"
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
            </div>
          </div>
        </div>
        <div class="flex">
          <!-- Inventory Table -->

          <div class="w-3/4 bg-white p-6 rounded-lg shadow-md mr-6">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold">Inventory</h2>
              <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                Add Item
              </a>
            </div>
            <div class="pagination" id="pagination">
              <a href="?page=1" class="text-blue-500 hover:underline">First</a>
            <?php if ($halamanAktif > 1) : ?>
            <a href="?page=<?= $halamanAktif - 1?>" class="text-blue-500 hover:underline">Previous</a>
            <?php endif; ?>
            <span class="mx-2">Page <?= $halamanAktif ?> </span> 
              <?php if ($halamanAktif < $jumlahHalaman) : ?>
            <a href="?page=<?= $halamanAktif + 1?>" class="text-blue-500 hover:underline">Next</a>
                <?php endif; ?>
            <a href="?page=<?= $jumlahHalaman ?>" class="text-blue-500 hover:underline">Last</a>
            </div>
            <div id="container">
            <table class="w-full text-left">
              <thead>
                <tr class="text-gray-500">
                <th class="pb-2">Product ID</th>
                  <th class="pb-2">Product</th>
                  <th class="pb-2">Category</th>
                  <th class="pb-2">Price</th>
                  <th class="pb-2">Stock</th>
                  <th class="pb-2">Actions</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($barang as $row) : ?>

                <tr class="border-b">
                  <td class="py-2"><?= $row["id"] ?></td>
                  <td class="py-2"><?= $row["produk"] ?></td>
                  <td class="py-2"><?= $row["kategori"]  ?></td>
                  <td class="py-2"><?= $row["harga"]  ?></td>
                  <td class="py-2"><?= $row["stock"]  ?></td>
                  <td class="py-2">
                    <a href="edit.php?id=<?=$row["id"]?>" class="text-blue-500 mr-2" >Edit</a>
                    <a href="delete.php?id=<?=$row["id"]?>"class="text-red-500" onclick="return confirm('apakah anda yakin ingin menghapus?')" >Delete</a>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tr>
              </tbody>
            </table>
            </div>
          </div>
          <!-- Overview Section -->
          <div class="w-1/4 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Overview</h2>
            <div class="mb-4">
              <div class="flex justify-between text-gray-500 mb-2">
                <span> Total Product </span>
                <span> <?= mysqli_num_rows($totalProduk) ?> </span>
              </div>
              <div class="flex justify-between text-gray-500 mb-2">
                <span> Total Stock  </span>
                <span> <?= $jumlahStock ?> </span>
              </div>
              <div class="flex justify-between text-gray-500 mb-2">
                <span> Product Sold </span>
                <span> <?= $stokTerjual ?> </span>
              </div>
              <div class="flex justify-between text-gray-500 mb-2">
                <span> Product Returned </span>
                <span> - </span>
              </div>
              <div class="flex justify-between text-gray-500 mb-2">
                <span> Stock Issued </span>
                <span> - </span>
              </div>
            </div>
            <h2 class="text-xl font-semibold mb-4">Stock Products</h2>
            <div class="grid grid-cols-3 gap-2">
              <img
                alt="Product Image 1"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/9fHQZsRllx00YKpLRtS6JhBczqBM5bzl0dwVlEx45wNB0fnTA.jpg"
                width="50"
              />
              <img
                alt="Product Image 2"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/tzJSX44ZV97oIh7hCbrbPF3hZfQpKEi6u66TtzGtjg7A0fnTA.jpg"
                width="50"
              />
              <img
                alt="Product Image 3"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/FEPfuCr6EP1eskEBXC2d1f1AfiPUKWRUYjidOnNk4zSrgef5E.jpg"
                width="50"
              />
              <img
                alt="Product Image 4"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/6gm2pBdCcJ7gP5ogOuoraLf1UA6VaKmZrfd0A78L6GSMofPnA.jpg"
                width="50"
              />
              <img
                alt="Product Image 5"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/unkNL012UjbUHFuDfV1j3mpwpqkEoRgcwKJ3FeQ4kUoLofPnA.jpg"
                width="50"
              />
              <img
                alt="Product Image 6"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/zKPzvnnghObeWS1PfXPzfow7NOwPoe3rG5OCyiZMuDseA9f5E.jpg"
                width="50"
              />
              <img
                alt="Product Image 7"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/iebeskGUSzpz7kK3xS1npBpDrAgKB0Jeq2gf6kh05uZRgef5E.jpg"
                width="50"
              />
              <img
                alt="Product Image 8"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/lXDvCefPnQv4NkRCEy7TJdMU3RnsvAAMegrgYSJ9aabKQffcC.jpg"
                width="50"
              />
              <img
                alt="Product Image 9"
                class="w-full h-full object-cover rounded-lg"
                height="50"
                src="https://storage.googleapis.com/a1aa/image/GwtfJ8Ne4kmX9k2LJ1GOWCvfts5gx9QZ6dvyqZsoPx5QQffcC.jpg"
                width="50"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/script.js"></script>
  </body>
</html>
