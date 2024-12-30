<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{   define('kasius',true);
    include("db_connect.php");
    include("../functions/functions.php");

    $id = clear_string($_POST['id']);
    $name = iconv("UTF-8","cp1251",clear_string($_POST['name']));
    $good = iconv("UTF-8","cp1251",clear_string($_POST['good']));
    $bad = iconv("UTF-8","cp1251",clear_string($_POST['bad']));
    $comment = iconv("UTF-8","cp1251",clear_string($_POST['comment']));

    mysqli_query($link,"INSERT INTO `table_reviews` (`reviews_id`, `products_id`, `name`, `good_reviews`, `bad_reviews`, `comment`, `date`, `moderat`)
VALUES(NULL,'".$id."','".$name."','".$good."','".$bad."','".$comment."',NOW(),'0')");
    echo 'yes';
}else {
    echo 'no';
}
?>