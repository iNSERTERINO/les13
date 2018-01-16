<?php
require_once 'config.php';
try{
    $connectStr = DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME;
    $db = new PDO($connectStr,DB_USER,DB_PASS);
    $db->exec("set names utf8");
    $link = new PDO("mysql:host=localhost;dbname=test;charset=UTF8");
    /* $sql = "select * from books";*/
    $sql = "SELECT * FROM books";
}catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$date = date("o-m-j H:i:s");
$sth = $db->prepare("INSERT INTO tasks (id,description,is_done,date_added) VALUES (NULL,:desc,0,:date)");
$sth->bindValue(':desc',"{$_POST['desc']}");
$sth->bindValue(':date',"$date");
$sth->execute();
header('Location: index.php');
var_dump($_POST);
var_dump($date);