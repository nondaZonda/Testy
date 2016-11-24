<!DOCTYPE html>
<html>
<head>
    <title>Zadanie 01</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>


<?php
/*
 * Występuje błąd w funkcji. Podmienia wielokrotnie do tego samego klucza.
 */

@include ("functions.php");

$fabrics = array('B' => 'BAWEŁNA', 'P' => 'POLIESTER', 'S' => 'SPANDEX', 'E' => 'ELASTAN', 'PO' => 'POLIAMID', 'EL' => 'ELASTAN', 'A' => 'AKRYL', 'AN' => 'ANGORA', 'NY' => 'NYLON', 'W' => 'WEŁNA', 'WO' => 'WEŁNA OWCZA', 'POL' => 'POLIWINYL', 'PVC' => 'PCV', 'SZJ' => 'SZTUCZNY JEDWAB', 'SK' => 'SKÓRA NATURALNA', 'POP' => 'POLIPROPYLEN');

$textiles = array('B 100%', 'B 80%, P 20%', 'NY 70%, EL 30%', 'B 75%, S 20%', 'SZJ 80%, E 20%');

$textile = $textiles[array_rand($textiles)];


echo "wzór: $textile, skład: </br>" . preg_replace(preg_filter('/$/','/',preg_filter('/^/','/', array_keys($fabrics))), array_values($fabrics), $textile);

?>

</body>
</html>