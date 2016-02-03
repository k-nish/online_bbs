<?php
  //POST送信が行われたら、下記の処理を実行
  //テストコメント
  if(isset($_POST) && !empty($_POST)){

    //データベースに接続
    //DB情報
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    //user情報
    $user = 'root';
    $password = '';
    //DB接続オブジェクト作成
    $dbh = new PDO($dsn,$user,$password);
    //接続したDBオブジェクトでutf8を使うことを指定
    $dbh->query('SET NAMES utf8');
    
    //SQL文作成(INSERT文)
    $nickname = htmlspecialchars($_POST['nickname']);
    $comment = htmlspecialchars($_POST['comment']);
    $time = date("Y-m-d H:i:s");

    //insert文実行
    $sql = 'INSERT INTO posts(`nickname`, `comment`,`created`) VALUES("'.$nickname.'","'.$comment.'","'.$time.'")';
    var_dump($sql);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute();
    

    //データベースから切断
    $dbh=null;
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

</head>
<body>
    <form action="bbs2.php" method="post">
      <input type="text" name="nickname" placeholder="nickname" required>
      <textarea type="text" name="comment" placeholder="comment" required></textarea>
      <button type="submit" >つぶやく</button>
    </form>

    <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:20</span></h2>
    <p>つぶやきコメント</p>

    <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:10</span></h2>
    <p>つぶやきコメント2</p>
</body>
</html>