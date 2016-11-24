<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 03</title>
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
@include ("functions.php");
$dataFromFile = array();
$dir = "files/";
$filesInDir = glob('files/*.csv');

function createNodeMap($parentId = 0){
    global $dataFromFile;
    if ($parentId != 0){
        echo '<ul>';
    }
    foreach ($dataFromFile as $position){
        if ($position['parent'] == $parentId){
            echo '<li>' . $position['name'];
            createNodeMap($position['id']);
            echo '</li>';
        }
    }
    if ($parentId != 0){
        echo '</ul>';
    }
}

?>
<div>
    <h2>Import danych z CSV</h2>
    <h3>Wybierz plik:</h3>
</div>

<div id="clear">
<form action="zad03.php" method="POST">
    <select name="fileOption">
        <option value="">Brak</option>
        <?php
        foreach ($filesInDir as $fn){
            echo '<option value="'. basename($fn) .'">'. basename($fn) .'</option>';
        }
        ?>
    </select>
    <button type="submit"><strong>Załaduj plik CSV</strong></button>
</form>
</div>
<div id="main">
    <?php

    /*
     * Wybór pliku do otwarcia
     */

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /*
     * Otwarcie pliku z CSV
     */
        $fileName = $_POST['fileOption'];
        $filePath = $dir . $fileName;
        $handle = fopen($filePath, "r");
        //debug($filePath);
        /*
         * Zrzut danych z pliku do tablicy
         */
        $counter = 0;
        if ($handle != FALSE) {

            $firstLine = TRUE;
            while (($data = fgetcsv($handle, 1000, ";")) != FALSE) {
                if ($firstLine == FALSE) {
                    //opracowuję dane od drugiej linii z pliku źródłowego
                    $dataFromFile[$counter] = [
                        'id' => $data[0],
                        'name' => $data[1],
                        'parent' => $data[2],
                    ];
                    $counter++;
                } else {
                    //pierwsza linia danych z pliku
                    $firstLine = FALSE;
                }
            }
        } else {
            echo "<strong>Nie udało się otworzyć pliku!</strong>";
        }
        /*
         * Opracowanie danych z tablicy
         */
        if (isset($dataFromFile)) {
            echo '<ul id="mainmenu">';
            createNodeMap();
            echo '</ul>';
        }
    }



    ?>


</div>
</body>
</html>