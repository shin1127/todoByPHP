<?php
function db_connect(){

    try{
        $dsn = 
        "mysql:dbname=phpTodo;host=localhost;charset=utf8";
        $user = "root";
        $password = "1234";

        $dbh = new PDO($dsn, $user, $password);
        $dbh->query("set names utf8");

        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $dbh;

    }catch (PROException $e){
        print "エラー:" . $e->getMessage() . "<br>";
        die();
    }
};

function updateDone(){

    if(isset($_POST["end"])){
  
        $id = $_POST["id"];
        print $id;
        $dbh = db_connect();
      
        $sql = "update phptodo set done = 1 where id = $id ";
      
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
      
        $dbh = null;
        unset($id);
    };
};




function showDo(){

    $dbh = db_connect();

    $sql = "select id, name, priority from phptodo where done = 0 order by id desc;";
    
    $stmt = $dbh->query($sql);
    $stmt->execute();
    
    
    while($task = $stmt->fetch(PDO::FETCH_ASSOC)){  // カラム名をkeyとして連想配列を返す
    
      if ($task["priority"] == "high"){
    
        $taskName = $task["name"];
    
        echo <<< HEREDOC
        <li>
        <span class='high'>
        ${task["name"]}
        </span>
        
        
        <form method="POST" action="index.php">
        <input type="submit" name="end" value=">END">
        <input type="hidden" name="id" value="${task['id']}"/>
        </form>
        </li>
        HEREDOC;
      }

    //     print "<li>";
    //     print "<span class='high'>";
    //     print $task["name"];
    //     print "</span>";
    //     print " ";
    //     print '
    //     <form method="POST" action="index.php">
    //     <input type="submit" name="end" value=">END">';
    
    //     print '<input type="hidden" name="id" value="';
    //     print $task['id'];
    //     print '"/>';
    //     print'</form>';
    //     print "</li>";
    //   }
    
      else if ($task["priority"] == "middle"){
        print "<li>";
        print "<span class='middle'>";
        print $task["name"];
        print "</span>";
        print " ";
        print '
        <form method="POST" action="index.php">
        <input type="submit" name="end" value=">END">';
    
        print '<input type="hidden" name="id" value="';
        print $task['id'];
        print '"/>';
        print'</form>';
        print "</li>";
      }
    
      else{
        print "<li>";
        print "<span class='low'>";
        print $task["name"];
        print "</span>";
        print " ";
        print '
        <form method="POST" action="index.php">
        <input type="submit" name="end" value=">END">';
    
        print '<input type="hidden" name="id" value="';
        print $task['id'];
        print '"/>';
        print'</form>';
        print "</li>";
      }
    
    };


}






function showDone(){

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

}

function addTodo(){

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


}