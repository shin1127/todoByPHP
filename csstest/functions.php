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
}
