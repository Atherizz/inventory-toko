<?php 
require 'function/function.php';

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$barisPerHalaman = 10;
$jumlahData = count(query("SELECT * FROM riwayat_transaksi"));
$jumlahHalaman = ceil($jumlahData / $barisPerHalaman);
if (isset($_GET["page"])) {
  $halamanAktif = $_GET["page"];
} else {
  $halamanAktif = 1;
}

$awalData = ($halamanAktif * $barisPerHalaman) - $barisPerHalaman;

$history = query("SELECT * FROM riwayat_transaksi LIMIT $awalData, $barisPerHalaman");


$product = mysqli_query($db,"SELECT * FROM riwayat_transaksi");



?>


<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body class="bg-blue-100 font-sans">
    <div class="flex">
      <!-- Sidebar -->
      <div class="w-1/5 bg-white h-screen p-5">
        <div class="flex items-center mb-10">
          <div class="bg-blue-500 rounded-full w-10 h-10"></div>
          <span class="ml-3 text-xl font-bold">SalesHub</span>
        </div>
        <nav>
          <ul>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="home.php">
                <i class="fas fa-home mr-3"></i>
                Home
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="index.php">
                <i class="fas fa-box mr-3"></i>
                Inventory
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-blue-500 font-bold" href="order.php">
                <i class="fas fa-shopping-cart mr-3"></i>
                Sales Report
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="report.php">
                <i class="fas fa-users mr-3"></i>
                Customer Report
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="customer.php">
                <i class="fas fa-chart-line mr-3"></i>
                Customer
              </a>
            </li>
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-chart-pie mr-3"></i>
                Growth
              </a>
            </li>
            <a href="cashier.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-file-alt w-6"> </i>
              <span class="ml-2"> Cashier </span>
            </a>
            <a
            <li class="mb-4">
              <a class="flex items-center text-gray-600" href="#">
                <i class="fas fa-cog mr-3"></i>
                Settings
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <!-- Main Content -->
      <div class="w-4/5 p-5">
        <div class="flex justify-between items-center mb-5">
          <div class="relative">
            <input
              class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Search"
              type="text"
            />
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
          </div>
          <div class="flex items-center">
            <button
              class="bg-white border border-gray-300 rounded-full px-4 py-2 mr-4"
            >
              Last 7 days
              <i class="fas fa-chevron-down ml-2"></i>
            </button>
          </div>
        </div>
        <div class="flex">
          <!-- Orders Table -->
          <div class="w-full bg-white p-5 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-5">
              <h2 class="text-xl font-bold">Sales Report</h2>
            </div>
            <a href="?page=1" class="text-blue-500 hover:underline">First</a>
            <?php if ($halamanAktif > 1) : ?>
            <a href="?page=<?= $halamanAktif - 1?>" class="text-blue-500 hover:underline">Previous</a>
            <?php endif; ?>
            <span class="mx-2">Page <?= $halamanAktif ?> </span> 
              <?php if ($halamanAktif < $jumlahHalaman) : ?>
            <a href="?page=<?= $halamanAktif + 1?>" class="text-blue-500 hover:underline">Next</a>
                <?php endif; ?>
            <a href="?page=<?= $jumlahHalaman ?>" class="text-blue-500 hover:underline">Last</a>
            <table class="w-full text-left">
              <thead>
                <tr>
                  <th class="pb-2">Order ID</th>
                  <th class="pb-2">Date</th>
                  <th class="pb-2">Product ID</th>
                  <th class="pb-2">Product</th>
                  <th class="pb-2">Quantity</th>
                  <th class="pb-2">Total</th>
                  <!-- <th class="pb-2">Actions</th> -->
                </tr>
              </thead>
              <tbody>
                <?php foreach ($history as $row) : ?>
                <tr class="border-t">
                  <td class="py-2">#0<?= $row["id_transaksi"] ?></td>
                  <td class="py-2"><?= $row["date"] ?></td>
                  <td class="py-2"><?= $row["id_barang"] ?></td>
                  <td class="py-2"><?= $row["barang"] ?></td>
                  <td class="py-2"><?= $row["qty"] ?></td>
                  <td class="py-2"><?= $row["subtotal"] ?></td>
                  <!-- <td class="py-2">
                    <a class="text-blue-500 mr-3" href="#">Edit</a>
                    <a class="text-red-500" href="#">Delete</a>
                  </td> -->
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
