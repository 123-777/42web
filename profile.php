<?php
include "includes/db.php";
include "includes/header.php";
if (!logged()) die("login");
?>

<div class="box">
  <h2>Perfil</h2>

  <img src="<?= $_SESSION['avatar'] ?? 'avatars/default.png' ?>" width="80"><br><br>

  <form method="post" enctype="multipart/form-data" action="avatar_upload.php">
    <input type="file" name="avatar">
    <button>Change Avatar</button>
  </form>
</div>
