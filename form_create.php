<?php
// var_dump($_POST);
// exit();
include('functions.php');

if (
  !isset($_POST['company_name']) || $_POST['company_name']=='' ||
  !isset($_POST['department_name']) || $_POST['department_name']=='' ||
  !isset($_POST['name']) || $_POST['name']=='' ||
  !isset($_POST['email']) || $_POST['email']=='' ||
  !isset($_POST['post_code']) || $_POST['post_code']=='' ||
  !isset($_POST['pre_name']) || $_POST['pre_name']=='' ||
  !isset($_POST['address']) || $_POST['address']=='' ||
  !isset($_POST['tel']) || $_POST['tel']=='' ||
  !isset($_POST['contact']) || $_POST['contact']=='' ||
  !isset($_POST['text']) || $_POST['text']==''
) {
  exit('ParamError');
}

$company_name = $_POST['company_name'];
$department_name = $_POST['department_name'];
$name = $_POST['name'];
$email = $_POST['email'];
$post_code = $_POST['post_code'];
$pre_name = $_POST['pre_name'];
$address = $_POST['address'];
$tel = $_POST['tel'];
$contact = $_POST['contact'];
$text = $_POST['text'];

// var_dump($_POST);
// exit();

// ---------------------------------------------CSVに書き出すーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
$write_data = "{$company_name} {$department_name} {$name} {$email} {$post_code} {$pre_name} {$address} {$tel} {$contact} {$text} \n";
$file = fopen('data/form.csv', 'a');
flock($file, LOCK_EX);
fwrite($file, $write_data);
// var_dump($write_data);
// exit();

// ファイルのロックを解除する
flock($file, LOCK_UN);
// ファイルを閉じる
fclose($file);
// -----------------------------------------------ここまでーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


// -----------------------------------------------DBにinsert---------------------------------------------------

$pdo = connect_to_db();

$sql = 'INSERT INTO contact_table(id, company_name, department_name, name, email, post_code, pre_name, address, tel, contact, text, created_at, updated_at) VALUES(NULL, :company_name, :department_name, :name, :email, :post_code, :pre_name, :address, :tel, :contact, :text, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
$stmt->bindValue(':department_name', $department_name, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':post_code', $post_code, PDO::PARAM_STR);
$stmt->bindValue(':pre_name', $pre_name, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':contact', $contact, PDO::PARAM_STR);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:form_read.php");
exit();
