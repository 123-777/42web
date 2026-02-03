<?php
session_start();
if (!isset($_SESSION['user_id'])) exit("login");

if (!isset($_FILES['avatar'])) exit("no file");

$allowed = ['image/png','image/jpeg'];
if (!in_array($_FILES['avatar']['type'], $allowed)) exit("invalid");

$name = uniqid().".png";
move_uploaded_file(
  $_FILES['avatar']['tmp_name'],
  "avatars/$name"
);

include "includes/db.php";

mysqli_query($conn, "
  UPDATE users SET
    pending_avatar='avatars/$name',
    avatar_approved=0
  WHERE id={$_SESSION['user_id']}
");

header("Location: profile.php");

