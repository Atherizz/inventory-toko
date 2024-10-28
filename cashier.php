<?php 

require 'function/functionpay.php';

session_start();

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$error = "";
$discount = 0;

if (isset($_POST["submit"])) {

  $product = $_POST["product"];
  $qty = (int)$_POST["qty"];

  $query = "SELECT stock FROM barang WHERE produk = '$product'";
  $result = mysqli_query($db, $query);

  if (mysqli_num_rows($result) == 1) {
    $ambilProduk = mysqli_fetch_assoc($result);
    $stokTersedia = (int)$ambilProduk["stock"];

    // cek apakah stok tersedia
    if ($stokTersedia >= $qty) {
      $stokSekarang = $stokTersedia - $qty;
      $query2 = "UPDATE barang
      SET
      stock = $stokSekarang
      WHERE produk = '$product'
      "; 
      mysqli_query($db, $query2);

      // menambah data ke detail transaksi
      if (addCart($_POST) > 0) {
      } else {
        $error = "produk tidak ditemukan!";
      }
    } else {
      echo "<script>
      alert('data gagal ditambahkan!')
      </script>";
      $error = "stok tidak mencukupi!, stok tersedia : " . $stokTersedia;
    }
  } 
} 


// menghitung subtotal
$query = "SELECT * FROM detail_transaksi";

$cashier = query($query);

$subtotal = 0;

foreach($cashier as $total) {
  $subtotal+=$total["subtotal"];
}

?>


<html>
  <head>
    <title>SalesHub - Cashier</title>
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
            <a href="report.php"
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded"
            >
              <i class="fas fa-users w-6"> </i>
              <span class="ml-2"> Customer Report</span>
            </a>
            <a 
              class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded" href="customer.php"
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
            <a class="flex items-center p-2 text-blue-500 bg-blue-100 rounded">
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
          <!-- Cashier Control -->
          <div class="col-span-2 bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-bold">Cashier Control</h2>
              <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Product
              </button>
            </div>
            <form action="" method="POST">
              <div class="mb-4">
                <label class="block text-gray-700"> Product Name </label>
                <input
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                  type="text" name="product"
                />
                <p style="color: red; font-style:italic;"><?= $error ?></p>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700"> Quantity </label>
                <input
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                  type="number" name="qty" required
                />
              </div>
              <button class="bg-blue-500 text-white px-4 py-2 rounded w-full" type="submit" name="submit">
                Add to Cart
              </button>
            </form>
          </div>
          <!-- Cart -->
          <div class="bg-white p-1 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Cart</h2>
            <table class="w-full text-left">
              <thead>
                <tr>
                <th class="pb-2">ID</th>
                  <th class="pb-2">Product Name</th>
                  <th class="pb-2">Qty</th>
                  <th class="pb-2">Price</th>
                  <th class="pb-2">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($cashier as $row) : ?>
                <tr class="border-t">
                <td class="py-2"><?= $row["id"] ?></td>
                  <td class="py-2"><?= $row["barang"] ?></td>
                  <td class="py-2"><?= $row["qty"] ?></td>
                  <td class="py-2"><?= $row["harga"] ?></td>
                  <td class="py-2"><?= $row["subtotal"] ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="mt-4">
              <div class="flex justify-between">
                <span class="font-bold"> Total Amount: </span>
                <span class="font-bold">Rp.<?= $subtotal ?></span>
              </div>
              <div class="mt-4">
              </div>
                <form action="" method="POST">
                <div class="mt-4">
                <label class="block text-gray-700 mb-2">
                  Customer ID
                </label>
                <input
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                  id="memberCard"
                  type="text" name="customer" required id="customer"
                /> 
              </div>
              </div>
              <!-- <button
                class="bg-green-500 text-white px-4 py-2 rounded w-full mt-4" name="discount"
                type="submit" onclick="applyDiscount()"
              >
                Apply Discount
              </button> -->
            
              <button
                class="bg-blue-500 text-white px-4 py-2 rounded w-full mt-4" type="submit" name="checkout" onclick="return confirm('apakah anda yakin ingin checkout?')"
              >
                Checkout
              </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php 
      if (isset($_POST["checkout"])) {
           // menambahkan transaksi baru
          $customerId = $_POST["customer"];
          // memeriksa apakah customer sudah terdaftar atau belum
          $queryCheckCustomer = "SELECT id FROM customer WHERE
          id = '$customerId'
          ";
  
          $resultCustomer = mysqli_query($db, $queryCheckCustomer);

        // jika customer belum pernah transaksi akan ditambahkan ke database
          if (mysqli_num_rows($resultCustomer) == 0) {
          $query = "INSERT INTO customer (id)
          VALUES ('$customerId')
          ";
          mysqli_query($db, $query);
          }
      
          if (mysqli_affected_rows($db) > 0) {
          $currentDate = date('Y-m-d H:i:s');
          }

          // apply diskon
          $error = "";
          $discount = 0;
          
          $inputMember = (int)$_POST["customer"];
      
          $queryCheckMember = "SELECT id FROM customer 
          WHERE id = '$inputMember' AND member_status = 'member'
          "; 
      
          $member = mysqli_query($db, $queryCheckMember);

          
          
          if (mysqli_num_rows($member) > 0) {
          $query = "SELECT * FROM diskon WHERE 
          masa_berlaku >= '$currentDate'
          ";
          $diskon = mysqli_query($db, $query);
          $result = mysqli_fetch_assoc($diskon);

          if (mysqli_num_rows($diskon) > 0) {

          if ($result["minimum_order"] <= $subtotal) {
            $subtotal -= $subtotal * $result["persentase"] / 100;
            $discount = $result["persentase"];
          } else {
            $error = "tidak memenuhi minimum order!";
          }

        } else {
          $error = "diskon tidak ditemukan!";
        }

          } else {
          $error = "anda bukan member!";
          $discount = 0;
      
          }
  
        // memasukkan data ke tabel transaksi
        $queryTransaksi = "INSERT INTO transaksi (customer_id, `date`, total)
        VALUE ('$customerId', '$currentDate', '$subtotal')
        ";
        mysqli_query($db, $queryTransaksi);
          
        // memindahkan detail transaksi ke riwayat transaksi
        $queryCopyHistory = "INSERT INTO riwayat_transaksi (id_transaksi, barang, id_barang, qty, harga, subtotal,`date`)
        SELECT id, barang, id_barang, qty, harga, subtotal, '$currentDate'
        FROM detail_transaksi;   
        ";
  
        mysqli_query($db, $queryCopyHistory);
          
        // menghapus data detail dtransaksi
        $queryClearCart = "DELETE FROM detail_transaksi";
        mysqli_query($db, $queryClearCart);
      } 
    ?>  
   <div class="bg-white p-4 rounded-lg shadow-md mt-6">
  <h3 class="text-lg font-bold mb-2">Discount and Final Amount</h3>
  <p style="color: red; font-style: italic"><?= $error ?></p>
  <div class="flex justify-between">
    <span class="font-bold">Discount:</span>
    <span class="font-bold" id="persentaseDiskon"><?= $discount ?>%</span>
  </div>
  <div class="flex justify-between mt-2">
    <span class="font-bold">Final Amount:</span>
    <span class="font-bold text-blue-500" id="finalAmount">Rp. <?= number_format($subtotal, 2) ?></span>
  </div>
</div>
  </body>
</html>
