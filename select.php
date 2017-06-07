<?php
  include 'header.php';
  include 'navbar.php';

//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db21;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td><a href="'.$result["url"].'" target="_blank"><img src="'.$result["img"].'"></a></td>';
    $view .= '<td>'.$result["name"].'</td>';
    $view .= '<td>'.$result["comment"].'</td>';
    $view .= '<td>'.$result["indate"].'</td>';
    $view .= '</tr>';
  }

}
?>

<!-- Main[Start] -->
<div id="content">
  <table>
    <tbody><?=$view?></tbody>
  </table>
</div>
<!-- Main[End] -->

</body>
</html>
