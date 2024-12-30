<?php
defined('kasius') or die('mzgavsi gverdi ar moidzebna!');
function clear_string($cl_str)
{
    $cl_str = strip_tags($cl_str);//— Удаляет HTML и PHP-теги из строки
    $cl_str = htmlspecialchars($cl_str);//— Преобразует специальные символы в HTML-сущности
    $cl_str = trim($cl_str);//— Удаляет пробелы

    return $cl_str;
}


//dajgufeba fasebis
function group_numerals($int){
    switch (strlen($int)) {
        case '4';
            $price = substr($int,0,1).' '.substr($int,1,4);
            break;
        case '5';
            $price = substr($int,0,2).' '.substr($int,2,5);
            break;
        case '6';
            $price = substr($int,0,3).' '.substr($int,3,6);
            break;
        case '7';
            $price = substr($int,0,1).' '.substr($int,1,3).' '.substr($int,4,7);
            break;
        default:
            $price = $int;
            break;
    }
    return $price;
}

/*function clear_string($value)
{

$mysqli = new mysqli("localhost", "root", "", "db_shop");
$value = strip_tags($value);
$value = $mysqli->real_escape_string($value);
$value = trim($value);
return $value;
}
*/

?>