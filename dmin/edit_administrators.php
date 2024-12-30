<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);
    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='edit_administrators.php'> ადმინის რედაქტირება</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    $id = clear_string($_GET["id"]);
    if ($_POST["submit_edit"]) {
        if ($_SESSION['auth_admin_login'] == 'admin') {

            $error = array();

            if (!$_POST["admin_login"]) $error[] = "მიუთითეთ უზერი!";
            if ($_POST["admin_pass"]) {
                $pass = md5(clear_string($_POST["admin_pass"]));
                $pass = strrev($pass);
                $pass = "pass='" . strtolower("mb03foo51" . $pass . "qj2jjdp9") . "',";
            }
            if (!$_POST["admin_fio"]) $error[] = "მიუთითეთ ფიო!";
            if (!$_POST["admin_role"]) $error[] = "მიუთითეთ წოდება!";
            if (!$_POST["admin_email"]) $error[] = "მიუთითეთ მეილი!";

            if ($_POST["view_orders"]) {
                $view_orders = "1";
            } else {
                $view_orders = "0";
            }

            if ($_POST["accept_orders"]) {
                $accept_orders = "1";
            } else {
                $accept_orders = "0";
            }

            if ($_POST["delete_orders"]) {
                $delete_orders = "1";
            } else {
                $delete_orders = "0";
            }

            if ($_POST["add_tovar"]) {
                $add_tovar = "1";
            } else {
                $add_tovar = "0";
            }

            if ($_POST["edit_tovar"]) {
                $edit_tovar = "1";
            } else {
                $edit_tovar = "0";
            }

            if ($_POST["delete_tovar"]) {
                $delete_tovar = "1";
            } else {
                $delete_tovar = "0";
            }

            if ($_POST["accept_reviews"]) {
                $accept_reviews = "1";
            } else {
                $accept_reviews = "0";
            }

            if ($_POST["delete_reviews"]) {
                $delete_reviews = "1";
            } else {
                $delete_reviews = "0";
            }

            if ($_POST["view_clients"]) {
                $view_clients = "1";
            } else {
                $view_clients = "0";
            }

            if ($_POST["delete_clients"]) {
                $delete_clients = "1";
            } else {
                $delete_clients = "0";
            }

            if ($_POST["add_news"]) {
                $add_news = "1";
            } else {
                $add_news = "0";
            }

            if ($_POST["delete_news"]) {
                $delete_news = "1";
            } else {
                $delete_news = "0";
            }

            if ($_POST["add_category"]) {
                $add_category = "1";
            } else {
                $add_category = "0";
            }

            if ($_POST["delete_category"]) {
                $delete_category = "1";
            } else {
                $delete_category = "0";
            }

            if ($_POST["view_admin"]) {
                $view_admin = "1";
            } else {
                $view_admin = "0";
            }

            if (count($error)) {


                $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
            } else {
                $querynew = "login='{$_POST["admin_login"]}',
                $pass
                fio='{$_POST["admin_fio"]}',
                role='{$_POST["admin_role"]}',
                email='{$_POST["admin_email"]}',
                phone='{$_POST["admin_phone"]}',
                view_orders='$view_orders',
                accept_orders='$accept_orders',
                delete_orders='$delete_orders',
                add_tovar='$add_tovar',
                edit_tovar='$edit_tovar',
                delete_tovar='$delete_tovar',
                accept_reviews='$accept_reviews',
                delete_reviews='$delete_reviews',
                view_clients='$view_clients',
                delete_clients='$delete_clients',
                add_news='$add_news',
                delete_news='$delete_news',
                add_category='$add_category',
                delete_category='$delete_category',
                view_admin='$view_admin'";

                $update = mysqli_query($link, "UPDATE reg_admin SET $querynew WHERE id = '$id'");
                $_SESSION['message'] = "<p id='form-success'>მომხმარებლის შეცვლილია!</p>";

            }
        }else
        {
            $msgerror = 'თქვენ არ გაქვთ ადმინისტრატორის რედაქტირების ნებართვა!';
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
        <title>სამართავი პანელი - ადმინის რედაქტირება</title>
    </head>
    <body>
    <div id="block-body">

        <?php
        include("include/block-header.php");
        ?>
        <div id="block-content">
            <div id="block-parameters">
                <p id="title-page">ადმინის რედაქტირება<strong></strong></p>
            </div>
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
            if (isset($_SESSION['message']))
            {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            $result = mysqli_query($link,"SELECT * FROM reg_admin WHERE id = '$id'");
            if (mysqli_num_rows($result) > 0)
            {
               $row = mysqli_fetch_array($result);
               do
               {
                   if ($row["view_orders"] == "1") $view_orders = "checked";
                   if ($row["accept_orders"] == "1") $accept_orders = "checked";
                   if ($row["delete_orders"] == "1") $delete_orders = "checked";
                   if ($row["add_tovar"] == "1") $add_tovar = "checked";
                   if ($row["edit_tovar"] == "1") $edit_tovar = "checked";
                   if ($row["delete_tovar"] == "1") $delete_tovar = "checked";
                   if ($row["accept_reviews"] == "1") $accept_reviews = "checked";
                   if ($row["delete_reviews"] == "1") $delete_reviews = "checked";
                   if ($row["view_clients"] == "1") $view_clients = "checked";
                   if ($row["delete_clients"] == "1") $delete_clients = "checked";
                   if ($row["add_news"] == "1") $add_news = "checked";
                   if ($row["delete_news"] == "1") $delete_news = "checked";
                   if ($row["view_admin"] == "1") $view_admin = "checked";
                   if ($row["add_category"] == "1") $add_category = "checked";
                   if ($row["delete_category"] == "1") $delete_category = "checked";
                echo '
                <form id="form-info"  method="POST">
                <ul id="info-admin">
                    <li><label>სახელი</label><input type="text" name="admin_login" value="'.$row["login"].'"/></li>
                    <li><label>პაროლი</label><input type="password" name="admin_pass" /></li>
                    <li><label>ფიო</label><input type="text" name="admin_fio" value="'.$row["fio"].'"/></li>
                    <li><label>წოდება</label><input type="text" name="admin_role" value="'.$row["role"].'"/></li>
                    <li><label>E-mail</label><input type="text" name="admin_email" value="'.$row["email"].'"/></li>
                    <li><label>ტელეფონი</label><input type="text" name="admin_phone" value="'.$row["phone"].'"/></li>
                </ul>

                <h3 id="title-privilege">პრივილეგიები</h3>
                <p id="link-privilege"><a id="select-all" >ყველას არჩევა</a> | <a id="remove-all">ყველაფრის მოხსნა</a></p>

                <div class="block-privilege">
                    <ul class="privilege">
                        <li><h3>შეკვეთები</h3></li>
                        <li>
                            <input type="checkbox" name="view_orders" id="view_orders" value="1" '.$view_orders.'/>
                            <label for="view_orders" >შეკვეთების ნახვა.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="accept_orders" id="accept_orders" value="1" '.$accept_orders.'/>
                            <label for="accept_orders" >შეკვეთების დამუშავება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_orders" id="delete_orders" value="1" '.$delete_orders.'/>
                            <label for="delete_orders" >შეკვეთების წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>ნივთები</h3></li>
                        <li>
                            <input type="checkbox" name="add_tovar" id="add_tovar" value="1" '.$add_tovar.'/>
                            <label for="add_tovar">ნივთის დამატება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="edit_tovar" id="edit_tovar" value="1" '.$edit_tovar.'/>
                            <label for="edit_tovar">ნივთის რედაქტირება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_tovar" id="delete_tovar" value="1" '.$delete_tovar.'/>
                            <label for="delete_tovar">ნივთის წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>კომენტარები</h3></li>
                        <li>
                            <input type="checkbox" name="accept_reviews" id="accept_reviews" value="1" '.$accept_reviews.'/>
                            <label for="accept_reviews">კომენტარის მოდერაცია.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_reviews" id="delete_reviews" value="1" '.$delete_reviews.'/>
                            <label for="delete_reviews">კომენტარის წაშლა.</label>
                        </li>
                    </ul>

                </div>

                <div class="block-privilege">
                    <ul class="privilege">
                        <li><h3>მომხმარებლები</h3></li>
                        <li>
                            <input type="checkbox" name="view_clients" id="view_clients" value="1" '.$view_clients.'/>
                            <label for="view_clients">მოხმარებლების ნახვა.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_clients" id="delete_clients" value="1" '.$delete_clients.'/>
                            <label for="delete_clients">მომხხმარებლების წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>სიახლეები</h3></li>
                        <li>
                            <input type="checkbox" name="add_news" id="add_news" value="1" '.$add_news.'/>
                            <label for="add_news">სიახლეების დამატება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_news" id="delete_news" value="1"'.$delete_news.'/>
                            <label for="delete_news">სიახლეების წაშლა.</label>
                        </li>
                    </ul>

                    <ul class="privilege">
                        <li><h3>კატეგორიები</h3></li>
                        <li>
                            <input type="checkbox" name="add_category" id="add_category" value="1" '.$add_category.'/>
                            <label for="add_category">კატეგორიების დამატება.</label>
                        </li>
                        <li>
                            <input type="checkbox" name="delete_category" id="delete_category" value="1" '.$delete_category.'/>
                            <label for="delete_category">კატეგორიების წაშლა.</label>
                        </li>
                    </ul>

                </div>

                <div id="block-privilege" >
                    <ul class="privilege">
                        <li><h3>ადინისტრატორები</h3></li>
                        <li>
                            <input type="checkbox" name="view_admin" id="view_admin" value="1" '.$view_admin.'/>
                            <label for="view_admin">ადმინისტრატორების ნახვა.</label>
                        </li>
                    </ul>
                </div>

                <p align="right"><input type="submit" id="submit_form" name="submit_edit" value="შენახვა" /></p>
            </form>
';
               }while($row = mysqli_fetch_array($result));
            }
            ?>



        </div>
    </div>
    </body>

    </html>
    <?php
}else {
    header("location: login.php");
}
?>