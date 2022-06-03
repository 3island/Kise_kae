<?php
include('functions.php');
session_start();
check_session_id();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Kise_kae</title>
</head>

<body>
  <header>
    <div class="header-container">
      <div class="header-list">
        <ul>
          <li>
            <h1>Kise_kae</h1>
          </li>
          <li><a href="form_read.php">編集</a></li>
          <li><a href="form_input.php">お問い合わせ</a></li>
          <li><a href="user_login.php">ログイン</a></li>
          <li><a href="user_logout.php">ログアウト</a></li>
          <li><?= "{$_SESSION['userName']}" ?></li>
        </ul>
      </div>
    </div>
  </header>

  <div class="main">
    <div class="top-image">
      <!-- <img src="views/img/neon-woman-dancing-fashion-model-woman-in-neon-light-portrait-of-beautiful-model-with-fluorescent-make-up-art-in-uv-colorful-make-up_199620-1018.webp"> -->
    </div>
  </div>

  <footer></footer>
</body>

</html>