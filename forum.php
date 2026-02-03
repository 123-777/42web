<?php
include "includes/db.php";
include "includes/header.php";

$cats = mysqli_query($conn, "SELECT * FROM categories");
?>

<div class="box">
  <h2>Forum</h2>

  <?php while ($c = mysqli_fetch_assoc($cats)): ?>
    <h3><?= htmlspecialchars($c['name']) ?></h3>

    <?php
    $topics = mysqli_query($conn, "
      SELECT topics.*, users.username
      FROM topics
      JOIN users ON users.id = topics.user_id
      WHERE category_id = {$c['id']}
      ORDER BY topics.id DESC
    ");
    ?>

    <?php while ($t = mysqli_fetch_assoc($topics)): ?>
      <div>
        <a href="topic.php?id=<?= $t['id'] ?>">
          <?= htmlspecialchars($t['title']) ?>
        </a>
        <small>por <?= $t['username'] ?></small>
      </div>
    <?php endwhile; ?>

  <?php endwhile; ?>
</div>
