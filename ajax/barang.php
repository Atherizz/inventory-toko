<?php 
require '../function/function.php';

$keyword = $_GET["keyword"];

$query = "SELECT * FROM barang WHERE
    produk LIKE '%$keyword%' OR
    kategori LIKE '%$keyword%'
    ";

$barang = query($query);
?>

<table class="w-full text-left">
              <thead>
                <tr class="text-gray-500">
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
                  <td class="py-2"><?= $row["produk"] ?></td>
                  <td class="py-2"><?= $row["kategori"]  ?></td>
                  <td class="py-2"><?= $row["harga"]  ?></td>
                  <td class="py-2"><?= $row["stock"]  ?></td>
                  <td class="py-2">
                    <a href="edit.php?id=<?=$row["id"]?>" class="text-blue-500 mr-2" >Edit</a>
                    <a href="delete.php?id=<?=$row["id"]?>"class="text-red-500">Delete</a>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tr>
              </tbody>
            </table>