<?php
include "includes/db.php";
include "includes/header.php";
?>

<div class="box">
  <h2>Welcome to 42web</h2>
  <p>A site focused on just chatting about specific topics. Just like forums. Created by 123</p>
</div>

<div class="box">
  <h3>Últimos tópicos</h3>

  <?php
  $topics = mysqli_query($conn, "
    SELECT topics.id, topics.title, topics.created_at, users.username
    FROM topics
    JOIN users ON users.id = topics.user_id
    ORDER BY topics.id DESC
    LIMIT 10
  ");

  if (mysqli_num_rows($topics) == 0) {
    echo "<p>No topics yet.</p>";
  }

  while ($t = mysqli_fetch_assoc($topics)):
  ?>
    <div style="margin-bottom:8px;">
      <a href="topic.php?id=<?= $t['id'] ?>">
        <?= htmlspecialchars($t['title']) ?>
      </a><br>
      <small>
        por <?= htmlspecialchars($t['username']) ?> • <?= $t['created_at'] ?>
      </small>
    </div>
  <?php endwhile; ?>
</div>

<?php if (!logged()): ?>
  <div class="box">
    <h3>Conta</h3>
    <a href="login.php">Login</a> •
    <a href="register.php">Register</a>
  </div>
<?php else: ?>
  <div class="box">
    <h3>Your Account</h3>
    <p>Logged in as <b><?= htmlspecialchars($_SESSION['username']) ?></b></p>
    <a href="profile.php">Profile</a> •
    <a href="new_topic.php">New Topic</a>
  </div>
<?php endif; ?>
