<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    define('kasius',true);
    include('db_connect.php');
    include('../functions/functions.php');

    $id = clear_string($_POST["id"]);
    $result = mysqli_query($link, "SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        do {
            $int = $int + ($row["cart_price"] * $row["cart_count"]);
        } while ($row = mysqli_fetch_array($result));

        echo group_numerals($int);
    }
}
?>