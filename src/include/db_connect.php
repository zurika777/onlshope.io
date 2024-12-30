<?php
defined('kasius') or die('mzgavsi gverdi ar moidzebna!');
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_database = 'db_shop';

$link = mysqli_connect($db_host, $db_user, $db_pass, $db_database);

if (mysqli_connect_error()) {
    die('Ошибка подключения к БД(' . mysqli_connect_errno() . ')'
        . mysqli_connect_error());
}
mysqli_set_charset($link, "UTF-8");
session_start();
/*$link = mysqli_connect("127.0.0.1", "root", "", "db_shop");

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}*/
?>