<?php
/*  davicyebuli parolis agdgena*/
if($_SERVER["REQUEST_METHOD"] == "POST") {  //orive adgilas shevcvale ' tu ramea daabrune
    define('kasius',true);
    include("db_connect.php");
    include("../functions/functions.php");


    $email = clear_string($_POST["email"]); // получаем email
    if ($email != "") {
        $result = mysqli_query($link, "SELECT email FROM reg_user WHERE email='$email'");
        if (mysqli_num_rows($result) > 0) {
            $newpass = fungenpass();

            // отправляем новый пароль
            $pass = md5($newpass);
            $pass = strrev($pass);
            $pass = strtolower("9nm2rv8q" . $pass . "2yo6z");


            /* parolis ganaxleba*/

            $update = mysqli_query($link, "UPDATE reg_user SET pass='$pass' WHERE email='$email'");

            send_mail('rcmodelebi@gmail.com', $email, 'axali paroli  Shop.ge -dan', 'tqveni paroli: ' .$newpass);
            echo true ;
        } else {
            echo "მზგავსი  E-mail ვერ მოიძებნა!";
        }
    } else {
        echo "მიუთითეთ E-mail სწორ ფორმატში!";

    }
}
?>