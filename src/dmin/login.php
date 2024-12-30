<?php
session_start();
define('kasius', true);
include ("include/db_connect.php");
include ("include/functions.php");


if ($_POST["submit_enter"]) {
    $login = clear_string($_POST["input_login"]);
    $pass = clear_string($_POST['input_pass']);


    if ($login && $pass) {

        $pass = md5($pass);
        $pass = strrev($pass);
        $pass = strtolower("mb03foo51".$pass."qj2jjdp9");

        $result = mysqli_query($link, "SELECT * FROM reg_admin WHERE login ='$login' AND pass ='$pass'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            $_SESSION['auth_admin'] = 'yes_auth';
            $_SESSION['auth_admin_login'] = $row["login"];
            // wodeba
            $_SESSION['admin_role']      = $row['role'];
            // privilegii block shekvetebze
            $_SESSION['accept_orders']   = $row['accept_orders'];
            $_SESSION['delete_orders']   = $row['delete_orders'];
            $_SESSION['view_orders']     = $row['view_orders'];

            // privilegii block nivtebze
            $_SESSION['delete_tovar']    = $row['delete_tovar'];
            $_SESSION['add_tovar']       = $row['add_tovar'];
            $_SESSION['edit_tovar']      = $row['edit_tovar'];

            // privilegii block komentarebze
            $_SESSION['accept_reviews']  = $row['accept_reviews'];
            $_SESSION['delete_reviews']  = $row['delete_reviews'];

            // privilegii block momxmareblebze
            $_SESSION['view_clients']    = $row['view_clients'];
            $_SESSION['delete_clients']  = $row['delete_clients'];


            // privilegii block siaxleebze
            $_SESSION['add_news']        = $row['add_news'];
            $_SESSION['delete_news']     = $row['delete_news'];

            // privilegii block kategoriebze
            $_SESSION['add_category']    = $row['add_category'];
            $_SESSION['delete_category'] = $row['delete_category'];

            // privilegii block adminebze
            $_SESSION['view_admin']      = $row['view_admin'];
            header('Location: index.php');
        } else {
            $msgerror = "არასწორი უზერია (ან) პაროლი!";
        }
    } else {
        $msgerror = "შეავსეთ ყველა ველი!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style_dmin.css" rel="stylesheet" type="text/css" />
    <title>სამართავი პანელი</title>
</head>
<body>
<div id="block-pass-login">
    <?php

    if ($msgerror)
    {
        echo '<p id="msgerror">'.$msgerror.'</p>';
    }
    ?>
<form method="POST">
    <ul id="pass-login">
        <li><label>უზერი</label><input type="text" name="input_login" /></li>
        <li><label>პაროლი</label><input type="password" name="input_pass" /></li>
    </ul>
    <p class="btn"><input type="submit" name="submit_enter" id="submit_enter" value="შესვლა" /></p>
</form>
</div>
</body>
</html>