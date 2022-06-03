<?php 
include('functions.php');

// var_dump($_POST);
// exit();


// !issetで確認
if (
  !isset($_POST['userName']) || $_POST['userName']=='' ||
  !isset($_POST['email']) || $_POST['email']=='' ||
  !isset($_POST['userPassword']) || $_POST['userPassword']==''
) {
  exit('ParamError');
}


// ＄_POSTできたデータを変数に入れる
$userName = $_POST['userName'];
$email = $_POST['email'];
$password = $_POST['userPassword'];


// DB接続
$pdo = connect_to_db();

// sql作成＆実行
$sql = 'INSERT INTO users_table (id, userName, email, userPassword, is_admin, is_deleted, created_at, updated_at) VALUES (NULL, :userName, :email, :userPassword, 0, 0, now(), now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':userPassword', $password, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


// 画面移動
header('Location:top_page.php');
exit();