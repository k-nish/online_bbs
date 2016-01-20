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
    
    //サニタイズ、$nickname,$comment,$timeを定義
    $nickname = htmlspecialchars($_POST['nickname']);
    $comment = htmlspecialchars($_POST['comment']);
     date_default_timezone_set('Asia/Manila');
    $time = Date("Y-m-d H:i:s");

    //iSQL(nsert文)
    $sql = 'INSERT INTO posts(`nickname`, `comment`,`created`)VALUES("'.$nickname.'","'.$comment.'","'.$time.'")';
    var_dump($sql);
    print '<br/>';
    //SQL文を実行
    $stmt = $dbh->prepare($sql);
    $stmt ->execute();

    //ステップ2.データベースエンジンにsql文で司令を出す
    $sql='SELECT*FROM posts';

    //SQL文実行
    $stmt = $dbh->prepare($sql);
    $stmt ->execute();

    $posts = array();

    //fetchを使って投稿内容を表示
    while(1)
         {
          //実行結果として得られたデータを表示
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if($rec==false){
                break;
            }
            $posts[] = $rec;
            //print $rec['id'];
            //print $rec['nickname'];
            //print $rec['created'];
            //print $rec['comment'];
            //print '<br/>';
         }
    
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
    <form action="bbs.php" method="post">
      <input type="text" name="nickname" placeholder="nickname" required>
      <textarea type="text" name="comment" placeholder="comment" required></textarea>
      <button type="submit" >つぶやく</button>
    </form>
    
<?php 
foreach ($posts as $post) { ?>
    <h2><a href="#"><?php echo $post['nickname'];?></a> <span><?php echo $post['created'];?><span></h2>
    <p><?php echo $post['comment'];?><p>
<?php
}
?>
</body>
</html>

