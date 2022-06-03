<?php
include('functions.php');
session_start();
check_session_id();

// DB接続
$pdo = connect_to_db();


// sql作成＆実行 欲しいデータをDBから取ってくる
$sql = 'SELECT * FROM contact_table LEFT OUTER JOIN (SELECT contact_id, COUNT(id) AS check_count FROM check_table GROUP BY contact_id) AS result_table ON contact_table.id = result_table.contact_id';

$stmt = $pdo->prepare($sql);


// ログインしているユーザーのID
$user_id = $_SESSION['user_id'];
// var_dump($user_id);
// exit();


try {
  $status = $stmt->execute();
  // ＄fetch Allで＄resultに入れてforeachで表示したい形式で$outputに入れる
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = '';
  foreach($result as $record) {
    
    $output .= "<tr>
    <td>{$record['id']}</td>
    <td>{$record['company_name']}</td>
    <td>{$record['department_name']}</td>
    <td>{$record['name']}</td>
    <td>{$record['email']}</td>
    <td>{$record['post_code']}</td>
    <td>{$record['pre_name']}</td>
    <td>{$record['address']}</td>
    <td>{$record['tel']}</td>
    <td>{$record['contact']}</td>
    <td>{$record['text']}</td>
    <td>{$record['created_at']}</td>
    <td>{$record['updated_at']}</td>
    <td><a class='check' href='form_check.php?user_id={$user_id}&contact_id={$record["id"]}'>既読{$record["check_count"]}</a></td>
    <td><a class= href='user_login_delete.php?id={$record["id"]}'>delete</a></td>
    </tr>";
  }
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Document</title>
  <style>
  a {
    display: block;
    margin: 30px 0;
    text-decoration: none;
  }

  legend {
    font-size: 30px;
    font-weight: bold;
    padding-top: 60px;
    text-align: center;
  }

  .right {
    display: flex;
    justify-content: right;
  }

  .right a {
    margin-right: 20px;
  }

  .check {
    padding: 5px 20px;
  }
</style>
</head>
<body>
  <fieldset>
    <legend>CONTACT</legend>
    <div class="right">
      <a href="top_page.php">TOP</a>
      <a href="user_read.php">USER</a>
    </div>
    
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">会社名</th>
          <th scope="col">部署</th>
          <th scope="col">氏名</th>
          <th scope="col">メール</th>
          <th scope="col">郵便番号</th>
          <th scope="col">都道府県</th>
          <th scope="col">住所</th>
          <th scope="col">電話</th>
          <th scope="col">サービス</th>
          <th scope="col">内容</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>
</html>