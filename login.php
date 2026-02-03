<?php
include "includes/db.php";
session_start();

if ($_POST) {
  $u = $_POST['username'];
  $p = $_POST['password'];

  $q = mysqli_query($conn, "SELECT * FROM users WHERE username='$u'");
  $user = mysqli_fetch_assoc($q);

  if ($user && password_verify($p, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['is_admin'] = $user['is_admin'];
    header("Location: index.php");
  }
}
?>

<form method="post" class="box">
  <input name="username" placeholder="Usuário"><br><br>
  <input type="password" name="password" placeholder="Senha"><br><br>
  <button>Login</button>
</form>
