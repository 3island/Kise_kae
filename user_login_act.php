<?php
include('functions.php');
session_start();
// データ受け取り
// var_dump($_POST);
// exit();


$username = $_POST['userName'];
$password = $_POST['userPassword'];

// DB接続
$pdo = connect_to_db();

// SQL実行
// username，password，is_deletedの3項目全てを満たすデータを抽出する．
$sql = 'SELECT * FROM users_table WHERE userName=:userName AND userPassword=:userPassword AND is_deleted=0';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userName', $username, PDO::PARAM_STR);
$stmt->bindValue(':userPassword', $password, PDO::PARAM_STR);


try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


// ユーザ有無で条件分岐
$val = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$val) {
  echo "<p>ログイン情報に誤りがあります</p>";
  echo "<a href=top_page.php>ログイン</a>";
  exit();
} else {
  $_SESSION = array();
  $_SESSION['user_id'] = $val['id'];
  $_SESSION['session_id'] = session_id();
  $_SESSION['is_admin'] = $val['is_admin'];
  $_SESSION['userName'] = $val['userName'];
  $_SESSION['userPassword'] = $val['userPassword'];
  header("Location:top_page.php");
  exit();
}