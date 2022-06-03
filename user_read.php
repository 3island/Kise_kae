<?php
include('functions.php');
session_start();
check_session_id();

// ------------------------------------------CSV------------------------------------------------
// データまとめ用の空文字変数
// $str = '';
// $array = array();
// ファイルを開く（読み取り専用）
// $file = fopen('data/form.csv', 'r');
// ファイルをロック
// flock($file, LOCK_EX);
// fgets()で1行ずつ取得→$lineに格納
// if ($file) {
//   while ($line = fgetcsv($file)) {
//     $str .="<tr>";
//     // 取得したデータを`$str`に追加する
//     for($i = 0; $i < count($line); $i++){
//       $str .="<td>".$line[$i]."</td> \n";
//       array_push($array, $line);
//     }
//   }
//   $str .="</tr>";
// }
// ロックを解除する
// flock($file, LOCK_UN);
// ファイルを閉じる
// fclose($file);
// -----------------------------------------------------------------------------------------------

$pdo = connect_to_db();


// sql作成＆実行 欲しいデータをDBから取ってくる
$sql = 'SELECT * FROM users_table';
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
  // ＄fetch Allで＄resultに入れてforeachで表示したい形式で$outputに入れる
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = '';
  foreach($result as $record) {
    $output .= "<tr>
    <td>{$record['id']}</td>
    <td>{$record['userName']}</td>
    <td>{$record['email']}</td>
    <td>{$record['userPassword']}</td>
    <td>{$record['is_admin']}</td>
    <td>{$record['is_deleted']}</td>
    <td>{$record['created_at']}</td>
    <td>{$record['updated_at']}</td>
    <td><a href='user_edit.php?id={$record["id"]}'>edit</a></td>
    <td><a href='form_delete.php?id={$record["id"]}'>delete</a></td>
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
    padding-top: 40px;
    text-align: center;
  }

  .right {
    display: flex;
    justify-content: right;
  }

  .right a {
    margin-right: 40px;
  }
</style>
</head>
<body>
  <fieldset>
    <legend>ACCOUNT</legend>
    <div class="right">
      <a href="top_page.php">TOP</a>
      <a href="form_read.php">FORM</a>
    </div>
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">name</th>
          <th scope="col">email</th>
          <th scope="col">password</th>
          <th scope="col">is_admin</th>
          <th scope="col">is_deleted</th>
          <th scope="col">created_at</th>
          <th scope="col">updated_at</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>
</html>