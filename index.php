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
if (($_GET) != null){
    /*$sth = $db->prepare("SELECT * FROM books WHERE isbn LIKE :isbn AND name LIKE :name AND author LIKE :author");
    $sth->bindValue(':author', "%{$_GET['author']}%");
    $sth->bindValue(':name', "%{$_GET['name']}%");
    $sth->bindValue(':isbn', "%{$_GET['isbn']}%");
    $sth->execute();*/
    switch ($_GET['action']){
        case 'delete':
            $sth = $db->prepare("DELETE FROM tasks WHERE id LIKE :id ");
            $sth->bindValue(':id',"%{$_GET['id']}%");
            $sth->execute();
            break;
        case 'done':
            $sth = $db->prepare("UPDATE tasks SET is_done='1' WHERE id LIKE :id");
            $sth->bindValue(':id',"%{$_GET['id']}%");
            $sth->execute();
            break;
    }
}
$sth = $db->prepare("SELECT * FROM tasks");
$sth->execute();
var_dump($_GET);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>Список дел на сегодня</h2>
<form action="save.php" method="POST">
    <input type="text" name="desc" placeholder="Опишите свою задачу">
    <input type="submit" name="save" value="Сохранить">
</form>
<form action="" method="POST">
    <select name="sort" id="sort">
        <option value="date">Дате добавления</option>
        <option value="done">Статусу</option>
        <option value="desc">Описанию</option>
    </select>
    <input type="submit" value="Отсортировать">
</form>
<table>
    <tbody>
    <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th> </th>
    </tr>
    <?php
    while ($res = $sth->fetch(PDO::FETCH_BOTH)){?>
        <tr>
            <td><?=$res['description']?></td>
            <td><?=$res['date_added']?></td>
            <td><?php if ($res['is_done'] > 0){echo "<span class='ready'>Выполнено</span>";}else{echo "<span class='not-ready'>В процессе</span>";}?></td>
            <td><a href="<?='?id='.$res['id'].'&action=done'?>">Изменить</a><a href="<?='?id='.$res['id'].'&action=done'?>">Выполнить</a><a href="<?='?id='.$res['id'].'&action=delete'?>">Удалить</a></td>
        </tr>
    <?php }
    ?>
    </tbody>
</table>
</body>
</html>