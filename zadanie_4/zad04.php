<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 04</title>
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
// Dodatkowe funkcje
@include ("functions.php");
// Połączenie z bazą
@include("mysqli_connect.php");

$dataFromFile = array();
$dir = "files/";
$filesInDir = glob('files/*.csv');

?>
<div id="main">
    <div id="data">
        <h2>Dane pobrane z serwera.</h2>
        <h3>Tabela produkty</h3>
        <?php
        // Wyświetlenie wszystkich danych z bazy.
        $query = "SELECT * FROM products_tb";
        $result = mysqli_query($dbc, $query);
        $i = 1;
        if ($result->num_rows > 0) {
            echo "<table>
                <tr>
                    <th>L.p.</th>
                    <th>Nazwa</th>
                    <th>Ilość</th>
                    <th>Wartość</th>
                </tr>";
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>" .
                    "<td>" . $row['name'] . "</td>" .
                    "<td>" . $row['quantity'] . "</td>" .
                    "<td>" . $row['price'] . "</td>";
                echo "</tr>";
                $i++;
            }
            echo "</table>";
        } else {
            echo "<br/> Brak wyników wyszukiwania !";
        }
        ?>
    </div>
    <div>
        <h3>Wybierz plik z danymi do załadowania:</h3>
    </div>

    <div>
        <form action="zad04.php" method="POST">
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
</div>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /*
        * Otwarcie pliku z CSV
        */
        $fileName = $_POST['fileOption'];
        $filePath = $dir . $fileName;
        $handle = fopen($filePath, "r");
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
                        'name' => $data[0],
                        'quantity' => $data[1],
                        'price' => $data[2],
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
         * Załadowanie danych do bazy
         */
        if (isset($dataFromFile)) {
            $mysqlErrors = FALSE;
            foreach ($dataFromFile as $i) {
                $query = "INSERT INTO products_tb(name, quantity, price) 
                  VALUES ('" . $i['name'] . "','" . $i['quantity'] . "','" . $i['price'] . "')";

                $queryResult = mysqli_query($dbc, $query);
                if (!$queryResult){
                    $mysqlErrors = TRUE;
                }
            }
            if ($mysqlErrors == FALSE){
                echo "Poprawnie dodano dane. <br/>";
                header("Refresh:0");
            }else{
                echo "Wystąpił błąd. Nie udało się dodać danych. <br/>";
                echo "MySQL Error: " . mysqli_error($dbc) . "<br/>";
                echo "<p>Query : " . $query . "</p>";
            }
        }
    }
    
    ?>
</body>
</html>