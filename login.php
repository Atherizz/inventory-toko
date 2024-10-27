<?php 
session_start();
require 'function/function.php';

$error = "";

if(isset($_COOKIE["id"]) && isset($_COOKIE["password"])) {
  $id = $_COOKIE["id"];
  $password = $_COOKIE["password"];
  
  $result = mysqli_query($db, "SELECT username FROM user WHERE id = $id
  ");

  $row = mysqli_fetch_assoc($result);

  if ($password == hash("ripemd256", $row["username"])) {
    $_SESSION["login"] = true;
  }
}

if(isset($_POST["login"])) {

$username = $_POST["username"];
$password = $_POST["password"];

$query = "SELECT * FROM user WHERE
username = '$username'
";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
  if (password_verify($password, $row["password"])) {
    $_SESSION["login"] = true;
    if (isset($_POST["remember"])) {
      // buat cookie
      setcookie("id", $row["id"], time()+60*60);
      setcookie("password", hash("ripemd256", $row["password"]), time()+60*60);
    }
    $_SESSION["id"] = $row["id"];
    $_SESSION["username"] = $row["username"];

    header("Location: home.php");
    exit;



  } else {
  $error = "username / password salah!";
  }
} else {
  $error = "username tidak ditemukan";
}
}

if (isset($_SESSION["login"])) {
  header("Location: home.php");
  exit;
}

?>


<html>
  <head>
    <title>SalesHub - Login</title>
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
  <body class="bg-blue-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-2xl font-semibold mb-6 text-center">SalesHub Login</h2>
      <form action="" method="POST">
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="email"> Email </label>
          <input
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            id="username"
            type="username" name="username"
          />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 mb-2" for="password">
            Password
          </label>
          <input
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            id="password"
            type="password" name="password"
          />
        </div>
        <div class="flex justify-between items-center mb-4">
          <div>
            <input class="mr-2" id="remember-me" type="checkbox" name="remember" />
            <label class="text-gray-700" for="remember-me"> Remember me </label>
          </div>
          <a class="text-blue-500" href="register.php"> Don't have account? register!</a>
        </div>
        <?php if (isset($error)) ?>
        <p style="color:red;"><?= $error ?></p>
        <div class="flex justify-center">
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" type="submit" name="login">
            Login
          </button>
        </div>
      </form>
    </div>
  </body>
</html>
