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