<?php 
require 'function/function.php';
session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
// ambil data profil
$id = $_SESSION["id"];

$query = "SELECT * FROM user WHERE id = '$id'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);

$profil = query("SELECT * FROM user");

$transaksi = query("SELECT * FROM transaksi");
$pendapatanTotal = 0;

foreach($transaksi as $row) {
  $pendapatanTotal += $row["total"];
}

$resultTransaksi = mysqli_query($db, "SELECT * FROM transaksi");

$jumlahOrder = mysqli_num_rows($resultTransaksi);

$resultCustomer = mysqli_query($db, "SELECT * FROM customer");
$jumlahCustomer = mysqli_num_rows($resultCustomer);

?>

<html>
  <head>
    <title>SalesHub - Home</title>
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
            <a class="flex items-center p-2 text-blue-500 bg-blue-100 rounded">
              <i class="fas fa-home w-6"> </i>
              
              <span class="ml-2"> Home </span>
            </a>
            <a
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="index.php"
            >
              <i class="fas fa-box w-6"> </i>
              <span class="ml-2"> Inventory </span>
            </a> 
            <a  href="order.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-shopping-cart w-6"> </i>
              <span class="ml-2"> Sales Report </span>
            </a>
            <a href="report.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-users w-6"> </i>
              <span class="ml-2"> Customer Report</span>
            </a>
            <a  href="customer.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-chart-line w-6"> </i>
              <span class="ml-2"> Customer </span>
            </href=>
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
      <!-- Logout Button -->
      <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-full" type="submit" name="logout" onclick="return confirm('apakah anda yakin ingin logout?')">
        Logout
      </a>
      
      
      <?php if ($user["nickname"] == null && $user["image"] == null) { ?>
        <div class="flex items-center space-x-2">
    <div class="w-8 h-8 bg-gray-300 rounded-full">
    </div>
    <a href="profile.php">Create your username here!</a>
        </div>
        <?php } else { ?>
          <div class="flex items-center space-x-2">
    <div class="w-8 h-8 bg-gray-300 rounded-full">
    <img src="<?= $user["image"]?>" class="w-8 h-8 bg-gray-300 rounded-full">
    </div>
    <a href="profile.php"> <?= $user["nickname"] ?></a>
        </div>
        <?php } ?>
    </div>
        </div>
        <div class="grid grid-cols-3 gap-6">
          <!-- Welcome Section -->
          <div class="col-span-3 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Welcome to SalesHub!</h2>
            <p class="text-gray-700 mb-4">
              Your one-stop solution for managing sales, inventory, and customer
              relationships. Explore the features and get insights into your
              business performance.
            </p>
            <button class="bg-blue-500 text-white px-4 py-2 rounded">
              Get Started
            </button>
          </div>
          <!-- Quick Stats -->
          <div class="col-span-3 grid grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-bold mb-2">Total Sales</h3>
              <p class="text-3xl font-semibold text-blue-500">Rp. <?= $pendapatanTotal ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-bold mb-2">New Orders</h3>
              <p class="text-3xl font-semibold text-blue-500"><?= $jumlahOrder  ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-bold mb-2">New Customers</h3>
              <p class="text-3xl font-semibold text-blue-500"><?= $jumlahCustomer ?></p>
            </div>
          </div>
          <!-- Recent Activities -->
          <div class="col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Recent Activities</h2>
            <ul>
              <li class="flex items-center justify-between mb-4">
                <div>
                  <p class="text-gray-700">
                    <span class="font-semibold"> John Smith </span>
                    placed an order for
                    <span class="font-semibold"> $150 </span>
                  </p>
                  <p class="text-gray-500 text-sm">2 hours ago</p>
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                  View
                </button>
              </li>
              <li class="flex items-center justify-between mb-4">
                <div>
                  <p class="text-gray-700">
                    <span class="font-semibold"> Jane Doe </span>
                    registered as a new customer
                  </p>
                  <p class="text-gray-500 text-sm">3 hours ago</p>
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                  View
                </button>
              </li>
              <li class="flex items-center justify-between mb-4">
                <div>
                  <p class="text-gray-700">
                    <span class="font-semibold"> Michael Johnson </span>
                    added a new product
                  </p>
                  <p class="text-gray-500 text-sm">5 hours ago</p>
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                  View
                </button>
              </li>
            </ul>
          </div>
          <!-- Notifications -->
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Notifications</h2>
            <ul>
              <li class="flex items-center justify-between mb-4">
                <div>
                  <p class="text-gray-700">New order received</p>
                  <p class="text-gray-500 text-sm">2 hours ago</p>
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                  View
                </button>
              </li>
              <li class="flex items-center justify-between mb-4">
                <div>
                  <p class="text-gray-700">New customer registered</p>
                  <p class="text-gray-500 text-sm">3 hours ago</p>
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                  View
                </button>
              </li>
              <li class="flex items-center justify-between mb-4">
                <div>
                  <p class="text-gray-700">Product stock running low</p>
                  <p class="text-gray-500 text-sm">5 hours ago</p>
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                  View
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
