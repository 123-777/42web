<?php
include "includes/db.php";
include "includes/header.php";

$id = intval($_GET['id']);

$topic = mysqli_query($conn, "
  SELECT topics.*, users.username
  FROM topics
  JOIN users ON users.id = topics.user_id
  WHERE topics.id = $id
");
$t = mysqli_fetch_assoc($topic);

$posts = mysqli_query($conn, "
  SELECT posts.*, users.username
  FROM posts
  JOIN users ON users.id = posts.user_id
  WHERE topic_id = $id
  ORDER BY posts.id ASC
");
?>

<div class="box">
  <h2><?= htmlspecialchars($t['title']) ?></h2>
  <small>criado por <?= $t['username'] ?></small>
</div>

<?php while ($p = mysqli_fetch_assoc($posts)): ?>
  <div class="box">
    <b><?= $p['username'] ?></b>
    <div><?= $p['content'] ?></div>
    <small><?= $p['created_at'] ?></small>
  </div>
<?php endwhile; ?>

<?php if (logged()): ?>
  <form method="post" class="box">
    <textarea name="reply"></textarea>
    <button>Responder</button>
  </form>
<?php endif; ?>

<?php
if ($_POST && logged()) {

  $raw = $_POST['reply'];

  $content = str_replace(
    '<img src="pending-image">',
    '<div class="pending">[pending...]</div>',
    $raw
  );

  $content = mysqli_real_escape_string($conn, $content);

  mysqli_query($conn, "
    INSERT INTO posts (topic_id, user_id, content)
    VALUES ($id, {$_SESSION['user_id']}, '$content')
  ");

  $post_id = mysqli_insert_id($conn);

  mysqli_query($conn, "
    UPDATE uploads
    SET post_id = $post_id
    WHERE user_id = {$_SESSION['user_id']}
      AND approved = 0
      AND post_id IS NULL
  ");

  header("Location: topic.php?id=$id");
}

?>
