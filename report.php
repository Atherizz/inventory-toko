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

$query = "SELECT * FROM transaksi LIMIT $awalData, $barisPerHalaman";

$customer = query($query);

$error = "";

if (isset($_POST["submit"])) {
  if (tambahDiskon($_POST) > 0) {
    echo "<script>
    alert('diskon berhasil ditambahkan!')
    </script>";
  } else {
    $error = "masukkan angka dari 1 - 100";
  }
}

?>

<html>
  <head>
    <title>SalesHub - Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
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
            <a href="home.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-home w-6"> </i>
              <span class="ml-2"> Home </span>
            </a>
            <a href="index.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-box w-6"> </i>
              <span class="ml-2"> Inventory </span>
            </a> 
            <a href="order.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-shopping-cart w-6"> </i>
              <span class="ml-2"> Sales Report </span>
            </a>
            <a class="flex items-center p-2 text-blue-500 bg-blue-100 rounded">
              <i class="fas fa-users w-6"> </i>
              <span class="ml-2"> Customer Report </span>
            </a>
            <a href="customer.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-chart-line w-6"> </i>
              <span class="ml-2"> Customer </span>
            </a>
            <a
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-chart-pie w-6"> </i>
              <span class="ml-2"> Growth </span>
            </a>
            <a href="cashier.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-file-alt w-6"> </i>
              <span class="ml-2"> Cashier </span>
            </a>
            <a
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-cog w-6"> </i>
              <span class="ml-2"> Settings </span>
            </a>
          </ul>
        </div>
      </div>
      <!-- Main Content -->
      <div class="flex-1 p-6">
        <div class="flex justify-between items-center mb-6">
          <div class="relative">
            <input
              class="pl-10 pr-4 py-2 border rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Search"
              type="text"
            />
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"> </i>
          </div>
          <div class="flex items-center space-x-4">
            <button
              class="bg-white border rounded-full px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Last 7 days
              <i class="fas fa-chevron-down ml-2"> </i>
            </button>
            <div class="flex items-center space-x-2">
            </div>
          </div>
        </div>
        <div class="grid grid-cols-3 gap-6">
          <!-- Customer Management -->
          <div class="col-span-2 bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-bold">Customer Management</h2>
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
                  <th class="pb-2">Payment ID</th>
                  <th class="pb-2">Customer ID</th>
                  <th class="pb-2">Date</th>
                  <th class="pb-2">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($customer as $row) : ?>
                <tr class="border-t">
                  <td class="py-2"><?= $row["id"]  ?></td>
                  <td class="py-2"><?= $row["customer_id"]  ?></td>
                  <td class="py-2"><?= $row["date"]  ?></td>
                  <td class="py-2"><?= $row["total"]  ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <!-- Discount and Membership -->
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Discount & Membership</h2>
            <div class="mb-4">
              <h3 class="text-lg font-semibold">Current Discounts</h3>
              <ul class="list-disc list-inside">
                <li>10% off on orders above $100</li>
                <li>20% off for members</li>
                <li>Buy 1 Get 1 Free on selected items</li>
              </ul>
            </div>
            <div class="mb-4">
              <h3 class="text-lg font-semibold">Membership Benefits</h3>
              <ul class="list-disc list-inside">
                <li>Exclusive discounts</li>
                <li>Early access to sales</li>
                <li>Free shipping on all orders</li>
              </ul>
            </div>
            <a class="bg-blue-500 text-white px-4 py-2 rounded w-full" href="member.php"> 
              Become a Member
            </a>
          </div>
        </div>
        <div class="mt-6">
          <h2 class="text-xl font-bold mb-4">Manage Discounts</h2>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold">Add New Discount</h3>
              <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Discount
              </button>
            </div>
            <form action="" method="POST">
              <div class="mb-4">
                <label class="block text-gray-700"> Discount Percentage </label>
                <input
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                  type="text" name="persentase" min="0" max="100" required
                />
              </div>
              <div class="mb-4">
                <label class="block text-gray-700"> Minimum Order Amount</label>
                <input
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                  type="number" name="minimum" required
                />
              </div>
              <div class="mb-4">
                <label class="block text-gray-700">
                  Expired Date
                </label>
                <input
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                  type="date" name="expired" required
                />
                <p style="color: red; font-style: italic;"><?= $error ?></p>
              </div>
              <button class="bg-blue-500 text-white px-4 py-2 rounded w-full" type="submit" name="submit">
                Save Discount
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
