<?php
defined('kasius') or die('mzgavsi gverdi ar moidzebna!');
function clear_string($cl_str)
{
    $cl_str = strip_tags($cl_str);//— Удаляет HTML и PHP-теги из строки
    $cl_str = htmlspecialchars($cl_str);//— Преобразует специальные символы в HTML-сущности
    $cl_str = trim($cl_str);//— Удаляет пробелы

    return $cl_str;
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