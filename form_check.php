<?php
// var_dump($_GET);
// exit();
include('functions.php');
session_start();
check_session_id();


// GETで取ってきたデータを変数に入れる
$user_id = $_GET['user_id'];
$contact_id = $_GET['contact_id'];



// DB接続
$pdo = connect_to_db();


// SQL  like_tableのuser_idとtodo_idを集計
$sql = 'SELECT COUNT(*) FROM check_table WHERE user_id=:user_id AND contact_id=:contact_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':contact_id', $contact_id, PDO::PARAM_STR);


try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$contact_count = $stmt->fetchColumn();


// like_create.php

if ($contact_count != 0) {
  // いいねされている状態
  $sql = 'DELETE FROM check_table WHERE user_id=:user_id AND contact_id=:contact_id';
} else {
  // いいねされていない状態
  $sql = 'INSERT INTO check_table (id, user_id, contact_id, is_done, checked_at) VALUES (NULL, :user_id, :contact_id, 0, now())';
}


// 以下は前項と変更なし
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':contact_id', $contact_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:form_read.php");
exit();