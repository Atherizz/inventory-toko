<?php 
require "function/function.php";

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$query = "SELECT * FROM customer";

$customer = query($query);

?>


<html>
  <head>
    <title>Customer Information</title>
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
          <span class="ml-3 text-xl font-bold"> SalesHub </span>
        </div>
        <nav>
          <ul>
            <a class="mb-4 flex items-center text-gray-700" href="home.php">
              <i class="fas fa-home mr-3"> </i>
              Home
            </a>
            <a class="mb-4 flex items-center text-gray-700" href="index.php">
              <i class="fas fa-box mr-3"> </i>
              Inventory
            </a>
            <a class="mb-4 flex items-center text-gray-700" href="order.php">
              <i class="fas fa-chart-line mr-3"> </i>
              Sales Report
            </a>
            <a class="mb-4 flex items-center text-gray-700" href="report.php">
              <i class="fas fa-users mr-3"> </i>
              Customer Report
            </a>
            <a class="mb-4 flex items-center text-blue-500"> 
              <i class="fas fa-user mr-3"> </i>
              Customer
            </a>
            <a class="mb-4 flex items-center text-gray-700">
              <i class="fas fa-chart-pie mr-3"> </i>
              Growth
            </a>
            <a class="mb-4 flex items-center text-gray-700" href="cashier.php">
              <i class="fas fa-cash-register mr-3"> </i>
              Cashier
            </a>
            <a class="mb-4 flex items-center text-gray-700">
              <i class="fas fa-cog mr-3"> </i>
              Settings
            </a>
          </ul>
        </nav>
      </div>
      <!-- Main Content -->
      <div class="w-4/5 p-5">
        <div class="flex justify-between items-center mb-5">
          <input
            class="p-2 rounded-lg shadow-md w-1/3"
            placeholder="Search"
            type="text"
          />
          <div class="flex items-center">
            <button class="bg-white p-2 rounded-lg shadow-md mr-3">
              Last 7 days
              <i class="fas fa-caret-down ml-1"> </i>
            </button>
          </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md">
          <h2 class="text-xl font-bold mb-5">Customer Information</h2>
          <table class="w-full">
            <thead>
              <tr class="text-left text-gray-500">
                <th>Customer ID</th>
                <th>Member Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customer as $row) : ?>
              <tr>
                <td><?= $row["id"] ?></td>
                <td><?= $row["member_status"] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
