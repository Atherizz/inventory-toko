<?php 
require 'function/function.php';

session_start();


if(isset($_POST["register"])) {
  if(register($_POST) > 0) {
    echo "<script>
    alert('registrasi berhasil!')
    document.location.href = 'login.php'
    </script>";
  } else {
    echo "<script>
   alert('registrasi gagal!')
    </script>";
  }
}
?>

\<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body class="bg-blue-100 font-sans">
    <div class="flex justify-center items-center h-screen">
      <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-5 text-center">Register</h2>
        <form method="POST" action="">
          <div class="mb-4">
            <label
              class="block text-gray-700 text-sm font-bold mb-2"
              for="username"
              >Username</label
            >
            <input
              type="text"
              id="username"
              placeholder="Username"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              name="username"
            />
          </div>
          <div class="mb-4">
            <label
              class="block text-gray-700 text-sm font-bold mb-2"
              for="password" 
              >Password</label
            >
            <input
              type="password"
              id="password"
              placeholder="Password"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              name="password"
    
            />
          </div>
          <div class="mb-4">
            <label
              class="block text-gray-700 text-sm font-bold mb-2"
              for="confirm-password"
              >Confirm Password</label
            >
            <input
              type="password"
              id="confirm-password"
              placeholder="Confirm Password"
              name="password2"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          <div class="flex items-center justify-between">
            <button
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              type="submit" name="register"
            >
              Register
            </button>
          </div>
          <div class="mt-4 text-center">
            <a href="login.php" class="text-blue-500 hover:text-blue-700"
              >Already have an account? Login</a
            >
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
