<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    define('kasius', true);
    include ("db_connect.php");
    include ("../functions/functions.php");

    $id = clear_string($_POST["id"]);
   $result = mysqli_query($link,"SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_product = '$id'");
    if (mysqli_num_rows($result) > 0)
    {
    $row = mysqli_fetch_array($result);
    $new_count = $row["cart_count"] +1;
    $update = mysqli_query($link,"UPDATE cart SET cart_count='$new_count' WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_product ='$id'");
    } else {
        // ищем в таблице table_products этот товар по его ID
        $result = mysqli_query($link, "SELECT * FROM table_products WHERE products_id = '$id'");
        $row = mysqli_fetch_array($result);
        // добавляем в таблицу cart данный товар - его ID, цена, дата добавления в корзину и IP покупателя
         mysqli_query($link,"INSERT INTO cart(cart_id_product,cart_price,cart_datetime,cart_ip)
VALUES('".$row['products_id']."','".$row['price']."',NOW(),'".$_SERVER['REMOTE_ADDR']."')");
    }
}
?>