<?php
$test_dir = "./test/test";
$test_id = $test_dir.$_GET["id"].".json";
$json_file = file_get_contents($test_id);
$json_array = json_decode($json_file, true);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<nav>
    <ul>
        <li><a href="list.php">Список тестов</a></li>
        <li><a href="admin.php">Загрузить тест</a></li>
    </ul>
</nav>
<form action="" method="POST">
    <?php
    echo "<pre>";
    $i = 0;
    foreach ($json_array as $questions) {
        echo "<fieldset><legend>".$questions["question"]."</legend>";
        foreach ($questions["answers"] as $answer) {
            echo "<label><input  value='".$answer."' type='radio' name='$i' required>".$answer."</label>";
        }
        echo "</fieldset>";
        $i++;
    }
    ?>
    <input class="button" type="submit" value="Отправить">
</form>
<?php
if($_POST){
    $count_q = 0;
    $true_answer = 0;
    foreach ($json_array as $questions) {
        if ($_POST[$count_q] == $questions["answer"]){
            $true_answer++;
        }
        $count_q++;
    }
    echo "Вы набрали ".$true_answer." правильных ответов из ".$count_q;
}
?>
</body>
</html>