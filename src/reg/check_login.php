<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    define('kasius',true);
    include("../include/db_connect.php");
    include("../functions/functions.php");
    $login = clear_string($_POST['reg_login']);
    $result = mysqli_query($link,"SELECT login FROM reg_user WHERE login = '$login'");
    if (mysqli_num_rows($result) > 0)
{
echo 'false';
}
    else
        {
        echo 'true';
}
}
?>