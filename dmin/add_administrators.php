<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);
    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='add_administrators.php'> ადმინის დამატება</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    if ($_POST["submit_add"]) {
        if ($_SESSION['auth_admin_login'] == 'admin') {

            $error = array();

            if ($_POST["admin_login"]) {
                $login = clear_string($_POST["admin_login"]);
                $query = mysqli_query($link, "SELECT login FROM reg_admin WHERE login='$login'");

                if (mysqli_num_rows($query) > 0) {
                    $error[] = "მომხმარებელი დაკავებულია";
                }

            } else {
                $error[] = "მუთითეთ მოხხმარებელი";
            }
            if (!$_POST["admin_pass"]) $error[] = "მიუთითეთ პაროლი!";
            if (!$_POST["admin_fio"]) $error[] = "მიუთითეთ ფიო!";
            if (!$_POST["admin_role"]) $error[] = "მიუთითეთ წოდება!";
            if (!$_POST["admin_email"]) $error[] = "მიუთითეთ მეილი!";
            if (count($error)) {

                $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
            } else {
                $pass = md5(clear_string($_POST["admin_pass"]));
                $pass = strrev($pass);
                $pass = strtolower("mb03foo51" . $pass . "qj2jjdp9");


                mysqli_query($link, "INSERT INTO `reg_admin` (`id`, `login`, `pass`, `fio`, `role`, `email`, `phone`, `view_orders`, `accept_orders`, `delete_orders`, `add_tovar`, `edit_tovar`, `delete_tovar`, `accept_reviews`, `delete_reviews`, `view_clients`, `delete_clients`, `add_news`, `delete_news`, `add_category`, `delete_category`, `view_admin`)
VALUES(NULL, '" . clear_string($_POST["admin_login"]) . "',
'" . $pass . "',
'" . clear_string($_POST["admin_fio"]) . "',
'" . clear_string($_POST["admin_role"]) . "',
'" . clear_string($_POST["admin_email"]) . "',
'" . clear_string($_POST["admin_phone"]) . "',
'" . $_POST["view_orders"] . "',
'" . $_POST["accept_orders"] . "',
'" . $_POST["delete_orders"] . "',
'" . $_POST["add_tovar"] . "',
'" . $_POST["edit_tovar"] . "',
'" . $_POST["delete_tovar"] . "',
'" . $_POST["accept_reviews"] . "',
'" . $_POST["delete_reviews"] . "',
'" . $_POST["view_clients"] . "',
'" . $_POST["delete_clients"] . "',
'" . $_POST["add_news"] . "',
'" . $_POST["delete_news"] . "',
'" . $_POST["add_category"] . "',
'" . $_POST["delete_category"] . "',
'" . $_POST["view_admin"] . "')");
                $_SESSION['message'] = "<p id='form-success'>მომხმარებელი დამატებულია!</p>";

            }
        }else
        {
            $msgerror = 'თქვენ არ გაქვთ ადმინისტრატორის დამატების ნებართვა!';
        }
    }
            ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="jquery_confirm/jquery.confirm.css" rel="stylesheet" type="text/css"/>
        <link href="js/fancyBox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="jquery_confirm/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="jquery_confirm/jquery.confirm.js"></script>
        <script type="text/javascript" src="js/fancyBox/source/jquery.fancybox.js" ></script>
        <script type="text/javascript" src="jquery_confirm/script.js"></script>
        <title>სამართავი პანელი - ადმინისტრატორები</title>
    </head>
    <body>
    <div id="block-body">

        <?php
        include("include/block-header.php");
        ?>
        <div id="block-content">
            <div id="block-parameters">
                <p id="title-page">ადმინის დამატება<strong></strong></p>
            </div>
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
            if (isset($_SESSION['message']))
            {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>

            <form id="form-info"  method="POST">
                <ul id="info-admin">
                    <li><label>სახელი</label><input type="text" name="admin_login" /></li>
                    <li><label>პაროლი</label><input type="password" name="admin_pass" /></li>
                    <li><label>ფიო</label><input type="text" name="admin_fio" /></li>
                    <li><label>წოდება</label><input type="text" name="admin_role" /></li>
                    <li><label>E-mail</label><input type="text" name="admin_email" /></li>
                    <li><label>ტელეფონი</label><input type="text" name="admin_phone" /></li>
                </ul>

                <h3 id="title-privilege">პრივილეგიები</h3>
                <p id="link-privilege"><a id="select-all" >ყველას არჩევა</a> | <a id="remove-all">ყველაფრის მოხსნა</a></p>

                <div class="block-privilege">
                    <ul class="privilege">
                        <li><h3>შეკვეთები</h3></li>
                        <li>
                            <input type="checkbox" name="view_orders" id="view_orders" value="1" />
                            <label for="view_orders" >შეკვეთების ნახვა.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="accept_orders" id="accept_orders" value="1" />
                            <label for="accept_orders" >შეკვეთების დამუშავება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_orders" id="delete_orders" value="1" />
                            <label for="delete_orders" >შეკვეთების წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>ნივთები</h3></li>
                        <li>
                            <input type="checkbox" name="add_tovar" id="add_tovar" value="1" />
                            <label for="add_tovar">ნივთის დამატება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="edit_tovar" id="edit_tovar" value="1" />
                            <label for="edit_tovar">ნივთის რედაქტირება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_tovar" id="delete_tovar" value="1" />
                            <label for="delete_tovar">ნივთის წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>კომენტარები</h3></li>
                        <li>
                            <input type="checkbox" name="accept_reviews" id="accept_reviews" value="1" />
                            <label for="accept_reviews">კომენტარის მოდერაცია.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_reviews" id="delete_reviews" value="1" />
                            <label for="delete_reviews">კომენტარის წაშლა.</label>
                        </li>
                    </ul>

                </div>

                <div class="block-privilege">
                    <ul class="privilege">
                        <li><h3>მომხმარებლები</h3></li>
                        <li>
                            <input type="checkbox" name="view_clients" id="view_clients" value="1" />
                            <label for="view_clients">მოხმარებლების ნახვა.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_clients" id="delete_clients" value="1" />
                            <label for="delete_clients">მომხხმარებლების წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>სიახლეები</h3></li>
                        <li>
                            <input type="checkbox" name="add_news" id="add_news" value="1" />
                            <label for="add_news">სიახლეების დამატება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_news" id="delete_news" value="1" />
                            <label for="delete_news">სიახლეების წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>კატეგორიები</h3></li>
                        <li>
                            <input type="checkbox" name="add_category" id="add_category" value="1" />
                            <label for="add_category">კატეგორიების დამატება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_category" id="delete_category" value="1" />
                            <label for="delete_category">კატეგორიების წაშლა.</label>
                        </li>
                    </ul>

                </div>

                <div id="block-privilege" >
                    <ul class="privilege">
                        <li><h3>ადინისტრატორები</h3></li>
                        <li>
                            <input type="checkbox" name="view_admin" id="view_admin" value="1" />
                            <label for="view_admin">ადმინისტრატორების ნახვა.</label>
                        </li>
                    </ul>
                </div>

                <p align="right"><input type="submit" id="submit_form" name="submit_add" value="დამატება" /></p>
            </form>

        </div>
    </div>
    </body>

    </html>
    <?php
}else {
    header("location: login.php");
}
?>