<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 02</title>
</head>
<body>


<?php
@include ("functions.php");

function codeROT16($text){
    $alphabet = array ('a','ą','b','c','ć','d','e','ę','f','g','h','i','j','k','l','ł','m','n','ń','o','ó','p','r','s','ś','t','u','w','y','z','ź','ż');
    $lowerCaseText = strtolower($text);
    $textArr = preg_split('//u', trim($lowerCaseText), -1, PREG_SPLIT_DELIM_CAPTURE);
    $resultArr = [];

    foreach ($textArr as $char){
        if (is_int(array_search($char, $alphabet))){
            array_push( $resultArr,  ($alphabet[((array_search($char, $alphabet) + 16 ) %32 )]));
        }else{
            array_push($resultArr, $char);
        }
    }
    $result = implode($resultArr, '');
    return $result;
}
?>


<div id="main">
    <form action="zad02.php" method="post">
        <label for="textSent">Wpis tekst do zakodowania ROT16:</label>
        </br>
        <textarea rows="4" cols="50" name="textSent">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (!empty($_POST['textSent'])){
                    $text = $_POST['textSent'];
                    echo $text;
                }
            }
            ?>
        </textarea>
        </br>
        <button type="submit">Koduj/Odkoduj</button>
    </form>
    <textarea rows="4" cols="50" name="textSent">
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (!empty($_POST['textSent'])){
                    $text = $_POST['textSent'];
                    echo codeROT16($text);
                }
            }
        ?>
    </textarea>
</div>
</body>
</html>