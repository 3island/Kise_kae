<?php
include('functions.php');


// DB接続
$pdo = connect_to_db();


// !issetで確認
if (
  !isset($_POST['userName']) || $_POST['userName']=='' ||
  !isset($_POST['userPassword']) || $_POST['userPassword']=='' ||
  !isset($_POST['id']) || $_POST['id']=='' 
) {
  exit('ParamError');
}


// ＄_POSTできたデータを変数に入れる
$userName = $_POST['userName'];
$password = $_POST['userPassword'];
$id = $_POST['id'];

// sql作成＆実行
$sql = 'UPDATE users_table SET userName = :userName, userPassword = :userPassword WHERE id=:id';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
$stmt->bindValue(':userPassword', $password, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);


try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


// 画面移動
header('Location:user_read.php');
exit();

?>