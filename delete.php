<?php 
require 'function/function.php';

$id = $_GET["id"];

    if (delete($id) > 0) {
        echo "<script>
        document.location.href = 'index.php'
        </script>";
    } else {
        echo "<script>
        gagal menghapus data
        </script>";
    }




?>