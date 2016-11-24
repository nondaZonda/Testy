<?php
/**
 * Created by PhpStorm.
 * User: ituser
 * Date: 2016-06-09
 * Time: 13:42
 */
function debug($var, $rodzaj = ''){
    switch ($rodzaj){
        case 'long':
            echo '<blockquote style="background-color: darkgray; padding: 10px 10px; color: white;"><pre>';
            var_dump($var);
            echo '</blockquote></pre>';
            break;
        default:
            echo '<blockquote style="background-color: darkgray; padding: 10px 10px; color: white;"><pre>';
            print_r($var);
            echo '</blockquote></pre>';
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandomRole()
{
    $roles = ['admin','user','uberuser'];
    $max = count($roles);

    return $roles[rand(0,($max-1))];
}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function getLines($file)
{
    $f = fopen($file, 'rb');
    $lines = 0;

    while (!feof($f)) {
        $lines += substr_count(fread($f, 8192), "\n");
    }

    fclose($f);

    return $lines;
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

?>

