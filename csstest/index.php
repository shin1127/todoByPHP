<?php

require_once("functions.php");

if(isset($_POST["submit"])){  // $_POSTにsubmitが存在するか？

    $name = $_POST["name"];
    $name = htmlspecialchars($name, ENT_QUOTES);  // SQLインジェクション対策の関数

    $priority = $_POST["priority"];

    $dbh = db_connect();

    // $sql = "insert into phptodo (name, done, priority) values (?, 0, ?)";  // SQLインジェクション対策のプレースホルダ(=?)
    // $stmt = $dbh->prepare($sql);

    // $stmt->bindValue(1, $name, PDO::PARAM_STR);  // 第一引数：何番目の?か　第二：対応する文字列を格納した変数など　第三：第二引数がどのデータ型になるかを指定する
                                                    // PDO::PARAM_STRの実態はINT型の2

    // $stmt->bindValue(2, $priority, PDO::PARAM_STR);
    // $stmt->execute();

    // ? は:hogeで代替できる
    $sql = "insert into phptodo (name, done, priority) values (:name, 0, :priority)";  // SQLインジェクション対策のプレースホルダ(=?)
    $stmt = $dbh->prepare($sql);

    // print("PARAM_STRは ");
    // print(PDO::PARAM_STR);

    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->bindValue(":priority", $priority, PDO::PARAM_STR);
    $stmt->execute();

    $dbh = null;
    unset($name);
    unset($priority);

}

if(isset($_POST["end"])){
  
  $id = $_POST["id"];
  print $id;
  $dbh = db_connect();

  $sql = "update phptodo set done = 1 where id = $id ";

  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $dbh = null;
  unset($id);


}

?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="hoge.css" />
    <title>Document</title>
  </head>
  <body>



  <form action="index.php" method="post">
    <span>Task Name</span>
    <input type="text" name="name">
    <br>
    <span>Priority</span>


    <select name="priority">


    <option value="high">High</option>
    <option value="middle">Middle</option>
    <option value="low">Low</option>
    </select>
    
<br>
    <button type="submit" name="submit">ADD</button>
    </form>



    <div class="compare-box">
      <div class="compare-left-wrap">
        <div class="compare-left-head">Do</div>
        <div class="compare-left">
          <ul class="list">


          <?php

$dbh = db_connect();

$sql = "select id, name, priority from phptodo where done = 0 order by id desc;";

$stmt = $dbh->query($sql);
$stmt->execute();


while($task = $stmt->fetch(PDO::FETCH_ASSOC)){  // カラム名をkeyとして連想配列を返す

  if ($task["priority"] == "high"){

    $taskName = $task["name"];

    print "<li>";
    print "<span class='high'>";
    print $task["name"];
    print "</span>";
    print " ";
    // print "<form name='$taskName' method='post'>";

    print '
    <form method="POST" action="myFileName.php">
    <input type="submit" name="end" value="END">';

    print '<input type="hidden" name="id" value="';
    print $task["id"];
    print '"/>';

    print 'END';
    print'</form>';

    // print $task["priority"];
    print "</li>";


  }

  else if ($task["priority"] == "middle"){
    print "<li>";
    print "<span class='middle'>";
    print $task["name"];
    print "</span>";
    print " ";
    print "</li>";
  }

  else{
    print "<li>";
    print "<span class='low'>";
    print $task["name"];
    print "</span>";
    print " ";
    print "</li>";
  }

};


?>

          </ul>
        </div>
      </div>
      <div class="compare-right-wrap">
        <div class="compare-right-head">Done</div>
        <div class="compare-right">
          <ul class="list">

          <?php

$dbh = db_connect();

$sql = "select id, name, priority from phptodo where done = 1 order by id desc;";

$stmt = $dbh->query($sql);
$stmt->execute();


while($task = $stmt->fetch(PDO::FETCH_ASSOC)){  // カラム名をkeyとして連想配列を返す

    print "<li>";
    print $task["name"];
    print $task["priority"];
    print "</li>";
};


?>
          </ul>
        </div>
      </div>
    </div>

    
</body>
</html>
