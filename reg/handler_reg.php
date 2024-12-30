<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    define('kasius', true);
    include("../include/db_connect.php");
    include("../functions/functions.php");
    $error = array();   //serverze gadatanis shemdeg utf8s  cp1251 cavshlit
    $login = iconv("UTF-8", "cp1251", strtolower(clear_string($_POST['reg_login'])));
    $pass = iconv("UTF-8", "cp1251", strtolower(clear_string($_POST['reg_pass'])));
    $surname = iconv("UTF-8", "cp1251", clear_string($_POST['reg_surname']));
    $name = iconv("UTF-8", "cp1251", clear_string($_POST['reg_name']));
    $patronymic = iconv("UTF-8", "cp1251", clear_string($_POST['reg_patronymic']));
    $email = iconv("UTF-8", "cp1251", clear_string($_POST['reg_email']));
    $phone = iconv("UTF-8", "cp1251", clear_string($_POST['reg_phone']));
    $address = iconv("UTF-8", "cp1251", clear_string($_POST['reg_address']));
    if (strlen($login) < 5 or strlen($login) > 15) {
        $error[] = "5 დან 15 სიმბოლო!";
    } else {
        $result = mysqli_query($link, "SELECT login FROM reg_user WHERE login='$login'");
        if (mysqli_num_rows($result) > 0) {
            $error[] = "დაკავებულია სახელი";
        }
    }
    if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "მიუთითეთ პაროლი  7 დან 15 სიმბოლომდე";
    if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "მიუთითეთ გვარი 3 დან 20 სიმბოლომდე";
    if (strlen($name) < 3 or strlen($name) > 15) $error[] = "მიუთითეთ სახელი 3 დან 15 სიმბოლომდე";
    if (strlen($patronymic) < 3 or strlen($patronymic) > 25) $error[] = "მიუთითეთ მამის სახელი 3 დან 25 სომბოლომდე";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($email))) $error[] = "მიუთითეთ კორექტულად email -ი";
    if (!$phone) $error[] = "მიუთუთეთ ტელეფონის ნომერი";
    if (!$address) $error[] = "მიუთითეთ მიწოდების ადგილი";
    if ($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha'])) $error[] = "სურათის კოდი არასწორია!";
    unset($_SESSION['img_captcha']);
    if (count($error)) {

        echo implode('<br/>', $error);
    } else {
        $pass = md5($pass);
        $pass = strrev($pass);
        $pass = "9nm2rv8q" . $pass . "2yo6z";
        $ip = $_SERVER['REMOTE_ADDR'];
        mysqli_query($link, "INSERT INTO `reg_user` (`id`, `login`, `pass`, `surname`, `name`, `patronymic`, `email`, `phone`, `address`, `datetime`, `ip`)
VALUES (NULL, '" . $login . "', '" . $pass . "', '" . $surname . "', '" . $name . "', '" . $patronymic . "', '" . $email . "', '" . $phone . "', '" . $address . "',NOW(), '" . $ip . "')");
        echo true;
    }
}
?>