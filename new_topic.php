if ($_POST) {

  // 1️⃣ conteúdo vindo do TinyMCE
  $raw = $_POST['content'];

  // 2️⃣ troca imagem por placeholder
  $content = str_replace(
    '<img src="pending-image">',
    '<div class="pending">[pending...]</div>',
    $raw
  );

  $content = mysqli_real_escape_string($conn, $content);
  $title   = mysqli_real_escape_string($conn, $_POST['title']);

  // 3️⃣ cria o tópico
  mysqli_query($conn, "
    INSERT INTO topics (category_id, user_id, title)
    VALUES (1, {$_SESSION['user_id']}, '$title')
  ");

  $topic_id = mysqli_insert_id($conn);

  // 4️⃣ cria o post
  mysqli_query($conn, "
    INSERT INTO posts (topic_id, user_id, content)
    VALUES ($topic_id, {$_SESSION['user_id']}, '$content')
  ");

  // 5️⃣ pega ID do post
  $post_id = mysqli_insert_id($conn);

  // 6️⃣ liga uploads pendentes a esse post
  mysqli_query($conn, "
    UPDATE uploads
    SET post_id = $post_id
    WHERE user_id = {$_SESSION['user_id']}
      AND approved = 0
      AND post_id IS NULL
  ");

  header("Location: topic.php?id=$topic_id");
}
