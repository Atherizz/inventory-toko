<?php 

require 'function/function.php';

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$error = "";
if(isset($_POST["submit"])) {
  $idMember = $_POST["member"];

  $queryMember = "SELECT id FROM customer WHERE
  id = '$idMember'"; 

 $resultMember = mysqli_query($db, $queryMember);

 if (mysqli_num_rows($resultMember) == 0) {
  $error = "id member tidak ditemukan!";
 } else {
  $queryActiveMember = "UPDATE customer 
  SET member_status = 'member'
  WHERE id = '$idMember'
  ";
    echo "<script>
    alert('berhasil registrasi member!')
    document.location.href = 'customer.php'
    </script>";
  
  mysqli_query($db, $queryActiveMember);
 }

}

?>

<html>
  <head>
    <title>SalesHub - Become a Member</title>
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
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-home w-6"> </i>
              <span class="ml-2"> Home </span>
            </li>
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-box w-6"> </i>
              <span class="ml-2"> Inventory </span>
            </li>
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-shopping-cart w-6"> </i>
              <span class="ml-2"> Orders </span>
            </li>
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-users w-6"> </i>
              <span class="ml-2"> Customer Report </span>
            </li>
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-chart-line w-6"> </i>
              <span class="ml-2"> Revenue </span>
            </li>
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-chart-pie w-6"> </i>
              <span class="ml-2"> Growth </span>
            </li>
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-file-alt w-6"> </i>
              <span class="ml-2"> Report </span>
            </li>
            <li
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-cog w-6"> </i>
              <span class="ml-2"> Settings </span>
            </li>
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
              <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
              <span> John Doe </span>
            </div>
          </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-2xl font-bold mb-4">Become a Member</h2>
          <p class="text-gray-700 mb-4">
            Join our membership program to enjoy exclusive benefits and
            discounts. Fill out the form below to become a member.
          </p>
          <form method="POST" action="">
            <div class="mb-4">
              <label class="block text-gray-700"> Full Name </label>
              <input
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                type="text" name="name"
              />
            </div>
            <div class="mb-4">
              <label class="block text-gray-700"> Member ID </label>
              <input
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                type="text" name="member"
              />
              <p style="color: red; font-style: italic;"><?= $error  ?></p>
            </div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded w-full" type="submit" name="submit"> 
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
