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

    print("PARAM_STRは ");
    print(PDO::PARAM_STR);

    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->bindValue(":priority", $priority, PDO::PARAM_STR);
    $stmt->execute();



    $dbh = null;
    unset($name);
    unset($priority);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO by PHP</title>
</head>
<body>
    <h1>todo by PHP</h1>
    <h2>やること</h2>

    <form action="index.php" method="post">
    <div>タスク名</div>
    <input type="text" name="name"><br>
    <select name="priority">
    <option value="high">高い</option>
    <option value="middle">普通</option>
    <option value="row">低い</option>
    </select>
    <br>

    <button type="submit" name="submit">追加</button>
    </form>

    <br>

<?php

$dbh = db_connect();

$sql = "select id, name, priority from phptodo where done = 0 order by id desc;";

$stmt = $dbh->query($sql);
$stmt->execute();


while($task = $stmt->fetch(PDO::FETCH_ASSOC)){

    print "<br>";
    print $task["name"];
    print $task["priority"];
};


?>


    
</body>
</html>
