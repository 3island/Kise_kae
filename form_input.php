<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/form.css">
  <title>Document</title>
</head>
<body>
  <div class="container">

    <div class=""></div>
    <form action="form_create.php" method="POST">
      <fieldset>
        <legend>お問い合わせ</legend>

        
        <div>
          <p>会社名</p>
          <input type="text" name="company_name">    
        </div>

        <div>
          <p>部署名</p>
          <input type="text" name="department_name">
        </div>

        <div>
          <p>お名前</p>
          <input type="text" name="name">
        </div>

        <div>
          <p>メールアドレス</p>
          <input type="email" name="email">
        </div>

        <div>
          <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
          <p>郵便番号:</p>
          〒<input type="text" name="post_code" onKeyUp="AjaxZip3.zip2addr(this,'','都道府県','住所');"><br>
          <p>都道府県:</p>
          <input type="text" name="pre_name"><br>
          <p>住所:</p>
          <input type="text" name="address">
        </div>

        <div>
          <p>電話番号</p>
          <input type="text" name="tel">
        </div>

        <div>
          <p>お問い合わせサービス名</p>
          <input type="text" name="contact">
        </div>

        <div>
          <p>お問い合わせ内容</p>
          <textarea name="text"></textarea>
        </div>

        <div>
          <button value="送信">送信</button>
        </div>
        
      </fieldset>
    </form>
  </div>
</body>
</html>