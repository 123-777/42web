<?php
session_start();
if (!isset($_SESSION['user_id'])) exit;

if (!isset($_FILES['file'])) exit;

$allowed = ['image/png','image/jpeg','image/gif'];
if (!in_array($_FILES['file']['type'], $allowed)) exit;

$name = uniqid().".png";
move_uploaded_file(
  $_FILES['file']['tmp_name'],
  "uploads/$name"
);

include "includes/db.php";

mysqli_query($conn, "
  INSERT INTO uploads (user_id, file, approved)
  VALUES ({$_SESSION['user_id']}, 'uploads/$name', 0)
");

/*
 NÃO retorna a imagem real
 retorna placeholder
*/
echo json_encode([
  "location" => "pending-image"
]);
