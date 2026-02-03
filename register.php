<?php
include "includes/db.php";

if ($_POST) {
  $u = $_POST['username'];
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);

  mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$u','$p')");
  header("Location: login.php");
}
?>

<form method="post" class="box">
  <input name="username" placeholder="username"><br><br>
  <input type="password" name="password" placeholder="password"><br><br>
  <button>Create Account</button>
</form>
