<?php
include('functions.php');
session_start();
check_session_id();
// var_dump($_GET);
// exit();

$id = $_GET['id'];


// DB接続
$pdo = connect_to_db();


// sql作成＆実行
$sql = 'SELECT * FROM users_table WHERE id = :id';
$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':id', $id, PDO::PARAM_STR);


// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($result);
  // exit();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="user_update.php" method="POST">
    <fieldset>
      <legend>編集</legend>
      <a href="user_login_read.php">一覧画面</a>
      <div>
        name: <input type="text" name="userName" value="<?= $result['userName']?>"><!---$recordは$sqlから取ってきたデータをfetchした変数--->
      </div>
      <div>
        password: <input type="text" name="userPassword" value="<?= $result['userPassword']?>">
      </div>
      <input type="hidden" name="id" value="<?= $result['id'] ?>">
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>
</body>
</html>