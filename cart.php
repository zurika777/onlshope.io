<?php
define('kasius',true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");
/*ini_set("display_errors", 1);
error_reporting(-1);*/
//unset($_SESSION['auth']); //sesiis gatishva
//setcookie('rememberme','',0, '/'); //cookis gacmenda
$id = clear_string($_GET["id"]);
$action = clear_string($_GET["action"]);

switch ($action) {
    case 'clear':
        $clear = mysqli_query($link,"DELETE FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
        break;

    case 'delete':
        $delete = mysqli_query($link,"DELETE FROM cart WHERE cart_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
        break;
}
if (isset($_POST["submitdata"]))
{
    if ($_SESSION['auth'] == true )
    {
        mysqli_query($link, "INSERT INTO `orders` (`order_id`, `order_datetime`, `order_dostavka`, `order_pay`, `order_type_pay`, `order_fio`, `order_address`, `order_phone`, `order_note`, `order_email`)
VALUES(NULL, NOW(),
'" . $_POST["order_delivery"] . "',
'" . $_POST["order_pay"] . "',
'" . $_POST["order_type_pay"] . "',
'" . $_SESSION['auth_surname'] . "' '" . $_SESSION['auth_name'] . "' '" . $_SESSION['auth_patronymic'] . "',
'" . $_SESSION['auth_address'] . "',
'" . $_SESSION['auth_phone'] . "',
'" . $_POST['order_note'] . "',
'" . $_SESSION['auth_email'] . "')");
    } else
        {
        $_SESSION["order_delivery"] = $_POST["order_delivery"];
        $_SESSION["order_pay"] = $_POST["order_pay"];
        $_SESSION["order_type_pay"] = $_POST["order_type_pay"];
        $_SESSION["order_fio"] = $_POST["order_fio"];
        $_SESSION["order_address"] = $_POST["order_address"];
        $_SESSION["order_phone"] = $_POST["order_phone"];
        $_SESSION["order_note"] = $_POST["order_note"];
        $_SESSION['order_email'] = $_POST["order_email"];


        mysqli_query($link, "INSERT INTO `orders` (`order_id`, `order_datetime`, `order_dostavka`, `order_pay`, `order_type_pay`, `order_fio`, `order_address`, `order_phone`, `order_note`, `order_email`)
VALUES(NULL, NOW(),
'" . clear_string($_POST["order_delivery"]) . "',
'" . clear_string($_POST["order_pay"]) . "',
'" . clear_string($_POST["order_type_pay"]) . "',
'" . clear_string($_POST["order_fio"]) . "',
'" . clear_string($_POST["order_address"]) . "',
'" . clear_string($_POST["order_phone"]) . "',
'" . clear_string($_POST["order_note"]) . "',
'" . clear_string($_POST["order_email"]) . "')");
    }
    $_SESSION["order_id"] = mysqli_insert_id($link);
    $result = mysqli_query($link, "SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        do {
            mysqli_query($link, "INSERT INTO buy_products(buy_id_order,buy_id_product,buy_count_product)
                                VALUES(
                                '" . $_SESSION["order_id"] . "',
                                '" . $row["cart_id_product"] . "',
                                '" . $row["cart_count"] . "'
                                )");

        } while ($row = mysqli_fetch_assoc($result));


    }
    header("Location: cart.php?action=completion");
}

$result = mysqli_query($link,"SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_product");
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);
    do
    {
        $int = $int + ($row["price"] * $row["cart_count"]);
    }

    while ($row = mysqli_fetch_assoc($result));

    $itogpricecart = $int;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link href="TrackBar/jQuery/trackbar.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="js/jcarouserllite_1.0.1.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery.TextChange.js"></script>
    <script type="text/javascript" src="TrackBar/jQuery/jquery.trackbar.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,300i,400,700&display=swap" rel="stylesheet">
    <!--[if lte IE 9]> <link rel="stylesheet" href="css/stylesie9.css"><![endif]-->
    <title>შეკვეთის კალათა</title>
</head>
<body>
<div id="block__body"> <!--igive konteineria container-->
    <?php include("include/block__header.php"); ?>   <!--block__header-->
    <div id="block__right">  <!--block__right-->
        <?php include("include/block-category.php");
        include("include/block-parameter.php");
        include("include/block-news.php");
        ?>   <!--block__header-->
    </div>    <!--/.block__right-->
    <div class="block__content">   <!--block__content-->
        <?php
        $action = clear_string($_GET["action"]);
        switch ($action) {
            case 'oneclick':
                echo '
              <div id="block-step">
              <div id="name-step">
              <div><a class="active" href="cart.php?action=oneclick">1. კალათა </a></div>
              <div><span>&rarr;</span></div>
              <div><a href="cart.php?action=confirm">2. საკონტაქტო ინფორმაცია </a></div>
              <div><span>&rarr;</span></div>
              <div><a href="#">3. დასასრული </a></div>
              </div>  <!--/.name-step-->
              <div id="clear-step">
              <p >ნაბიჯი 1 &rarr; 3 - დან</p>
              <a  href="cart.php?action=clear">გაწმენდა</a>
              </div> <!--/.step-clear-->
              </div> <!--/.block-step-->
              ';
                $result = mysqli_query($link, "SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_product ");
                if (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    echo '             
                <div id="header-list-cart">
                <div id="header1">სურათი</div>
                <div id="header2">ნივთის სათაური</div>
                <div id="header3">რაოდენობა</div>
                <div id="header4">ფასი</div>
                 </div>    
                ';
                    do
                    {
                        $int = $row["cart_price"] * $row["cart_count"];
                        $all_price = $all_price + $int;
                        if (strlen($row["images"]) > 0 && file_exists("uploads_images/".$row["images"]))
                        {
                            $img_path = 'uploads_images/'.$row["images"];
                            $max_width = 100;
                            $max_height = 100;
                            list($width, $height) = getimagesize($img_path);
                            $ratioh = $max_height/$height;
                            $ratiow = $max_width/$width;
                            $ratio = min($ratioh, $ratiow);
                            $width = intval($ratio*$width);
                            $height = intval($ratio*$height);
                        }else
                        {
                            $img_path = "images/no-image.png";
                            $width = 120;
                            $height = 105;
                        }
                        echo '
                <div class="block-list-cart">
                <div class="img-cart">
                <p><a href="view_content.php?id='.$row["products_id"].'"><img src="'.$img_path.'" width="'.$width.'"  height="'.$height.'" alt=""></a></p>
                </div>
                   <div class="title-cart">
                <p><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
                <p class="cart-mini_features">'.$row["mini_features"].'</p>
                </div>
                <div class="count-cart">
                <ul class="input-count-style">
                <li>
                <p iid="'.$row["cart_id"].'" class="count-minus">-</p>
                </li>
                <li>
                <p><input id="input-id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count-input"  type="text" value="'.$row["cart_count"].'"/></p>
                </li>
                <li>
                <p iid="'.$row["cart_id"].'" class="count-plus">+</p>
                </li>
                </ul>
                </div>
                <div id="tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> X <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.group_numerals($int).' ₾</p></div>
                <div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="images/bsk_item_del.png" alt=""></a></div>
                <div id="bottom-cart-line"></div>
                </div>';
                    }
                    while ($row = mysqli_fetch_assoc($result));
                    echo '
                        <div id="itog-cont">
                        <h2 class="itog-price">ჯამში : <strong>'.group_numerals($all_price).' </strong> ₾</h2>
                        <p class="button-next"><a class="btn" href="cart.php?action=confirm">შემდეგ</a></p>         
                        </div>';
                }
                else
                {
                    echo '<h3 id="clear-cart">კალათა ცარიელია</h3>';
                }
                break;
            case 'confirm':
                echo '
              <div id="block-step">
              <div id="name-step">
              <duv><a href="cart.php?action=oneclick">1. კალათა </a></duv>
              <div><span>&rarr;</span></div>
              <div><a class="active" href="cart.php?action=confirm">2. საკონტაქტო ინფორმაცია </a></div>
              <div><span>&rarr;</span></div>
              <div><a href="#">3. დასასრული </a></div>
              </div>  <!--/.name-step-->
              <div id="clear-step">
              <p >ნაბიჯი 2 &rarr; 3 - დან</p>
              </div> <!--/.step-clear-->
              </div> <!--/.block-step-->
              ';
                $chck = "";
                if ($_SESSION['order_delivery'] == "ფოსტით") $chck1 = "checked";
                if ($_SESSION['order_delivery'] == "კურიერით") $chck2 = "checked";
                if ($_SESSION['order_delivery'] == "მეთვითონ") $chck3 = "checked";
                echo '<h3 class="title-h3">აირჩიეთ მიწოდების მეთოდი: </h3>
                <form method="post">
                    <ul id="info-radio">
                        <li>
                            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="ფოსტით" ' .$chck1.' />
                            <label class="label_delivery" for="order_delivery1">ფოსტით</label>
                        </li>
                        <li>
                            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="კურიერით"  '.$chck2.' />
                            <label class="label_delivery" for="order_delivery2">კურიერით</label>
                        </li>
                        <li>
                            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="მეთვითონ" ' .$chck3.' />
                            <label class="label_delivery" for="order_delivery3">გამოძახებით</label>
                        </li>
                    </ul>
                    <h3 class="title-h3">გადახდის მეთოდი: </h3>
                    <ul id="info-radio">
                        <li>
                            <input type="radio" name="order_payment" class="order_payment" id="order_payment1" value="გადახდის სხვა მეთოდი" ' .$chck1.' />
                            <label class="label_payment" for="order_payment1">სხვა გადახდის მეთოდი</label>
                        </li>
                        <li>
                            <input type="radio" name="order_payment" class="order_payment" id="order_payment2" value="PayPal"  '.$chck2.' />
                            <label class="label_payment_pay" for="order_payment2">PayPal</label>
                        </li>
                    </ul>

                    <h3 class="title-h3">ინფორმაცია მიწოდების შესახებ: </h3>
                    <ul id="info-order">';
                if ($_SESSION['auth'] != true )
                {
                    echo '<li><label for="order_fio">ფიო<span class="star1">*</span></label><input type="text" name="order_fio" id="order_fio" value="'.$_SESSION["order_fio"].'" /><span class="order_span_style">მაგ : ივანე ჯავახიშვილი</span></li>
                  <li><label for="order_email">E-mail<span class="star1">*</span></label><input type="text" name="order_email" id="order_email" value="'.$_SESSION["order_email"].'"  /><span class="order_span_style">მაგ : admin@gmail.com</span></li>
                  <li><label for="order_phone">ტელეფონი<span class="star1">*</span></label><input type="text" name="order_phone" id="order_phone" value="'.$_SESSION["order_phone"].'"  /><span class="order_span_style">მაგ : 5 99 77-77-77</span></li>
                  <li><label class="order_label_style" for="order_address">მიწოდების აგილი<span class="star1">*</span></label><input type="text" name="order_address" id="order_address" value="'.$_SESSION["order_address"].'"  />
                  <span class="order_span_style">მაგ : ქ. თბილისი,<br/>ქუჩა. რუსთაველის 35, კორპ.2, ბნ.35</span></li>';
                }
                echo '<li><label class="order_label_style" for="order_note">დამატებით</label><textarea name="order_note">'.$_SESSION["order_note"].'</textarea><span>დაზუსტება მიწოდების ადგილის.<br /> შესაბამის დროს დარეკვა<br /> ჩვენი მენეჯერის მიერ</span></li></ul>
                    <p align="right"><input type="submit" name="submitdata" id="confirm-button-next" class="btn" value="შემდეგ" /></p>
                    </form>';
                break;
            case 'completion':
                echo '
              <div id="block-step">
              <div id="name-step">
              <duv><a href="cart.php?action=oneclick">1. კალათა </a></duv>
              <div><span>&rarr;</span></div>
              <div><a href="cart.php?action=confirm">2. საკონტაქტო ინფორმაცია </a></div>
              <div><span>&rarr;</span></div>
              <div><a class="active" href="#">3. დასასრული </a></div>
              </div>  <!--/.name-step-->
              <div id="clear-step">
              <p >ნაბიჯი 3 &rarr; 3 - დან</p>
              </div> <!--/.step-clear-->
              </div> <!--/.block-step-->
              <h3 class="title-h3">საბოლოო ინფორმაცია</h3>
              ';


                if ($_SESSION['auth'] == true) { // если пользователь авторизован
                    echo '<ul id="list-info">
                                <li><strong>მიწოდების მეთოდი : </strong>'.$_SESSION['order_delivery'].'</li>
                                <li><strong>E-mail : </strong>'.$_SESSION['auth_email'].'</li>
                                <li><strong>სახელი : </strong>'.$_SESSION['auth_surname'].' '.$_SESSION['auth_name'].' '.$_SESSION['auth_patronymic'].'</li>
                                <li><strong>მიწოდების ადგილი : </strong>'.$_SESSION['auth_address'].'</li>
                                <li><strong>ტელეფონი : </strong>'.$_SESSION['auth_phone'].'</li>
                                <li><strong>დამატებითი ინფორმაცია : </strong>'.$_SESSION['order_note'].'</li>
                        </ul>';
                } else { // если пользователь не авторизован
                    echo '<ul id="list-info">
                                <li><strong>მიწოდების მეთოდი : </strong>'.$_SESSION['order_delivery'].'</li>
                                <li><strong>E-mail : </strong>'.$_SESSION['order_email'].'</li>
                                <li><strong>სახელი : </strong>'.$_SESSION['order_fio'].'</li>
                                <li><strong>მიწოდების ადგილი : </strong>'.$_SESSION['order_address'].'</li>
                                <li><strong>ტელეფონი : </strong>'.$_SESSION['order_phone'].'</li>
                                <li><strong>დამატებითი ინფორმაცია : </strong>'.$_SESSION['order_note'].'</li>
                        </ul>';
                }
                echo '
                <h2 class="itog-price" align="right">ჯამი :<strong> '.$itogpricecart.'</strong> ₾</h2>  
                <p align="right" class="button-next"><a href="">გადახდა</a></p>
                ';

                break;
            default:
                echo '
              <div id="block-step">
              <div id="name-step">
              <div><a class="active" href="cart.php?action=oneclick">1. კალათა </a></div>
              <div><span>&rarr;</span></div>
              <div><a href="cart.php?action=confirm">2. საკონტაქტო ინფორმაცია </a></div>
              <div><span>&rarr;</span></div>
              <div><a href="#">3. დასასრული </a></div>
              </div>  <!--/.name-step-->
              <div id="clear-step">
              <p >ნაბიჯი 1 &rarr; 3 - დან</p>
              </div> <!--/.step-clear-->
              </div> <!--/.block-step-->
              ';
                $result = mysqli_query($link, "SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_product ");
                if (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    echo '             
                <div id="header-list-cart">
                <div id="header1">სურათი</div>
                <div id="header2">ნივთის სათაური</div>
                <div id="header3">რაოდენობა</div>
                <div id="header4">ფასი</div>
                 </div>    
                ';
                    do
                    {
                        $int = $row["cart_price"] * $row["cart_count"];
                        $all_price = $all_price + $int;
                        if (strlen($row["images"]) > 0 && file_exists("uploads_images/".$row["images"]))
                        {
                            $img_path = 'uploads_images/'.$row["images"];
                            $max_width = 100;
                            $max_height = 100;
                            list($width, $height) = getimagesize($img_path);
                            $ratioh = $max_height/$height;
                            $ratiow = $max_width/$width;
                            $ratio = min($ratioh, $ratiow);
                            $width = intval($ratio*$width);
                            $height = intval($ratio*$height);
                        }else
                        {
                            $img_path = "images/no-image.png";
                            $width = 120;
                            $height = 105;
                        }
                        echo '
                <div class="block-list-cart">
                <div class="img-cart">
                <p><a href="view_content.php?id='.$row["products_id"].'"><img src="'.$img_path.'" width="'.$width.'"  height="'.$height.'" alt=""></a></p>
                </div>
                   <div class="title-cart">
                <p><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
                <p class="cart-mini_features">'.$row["mini_features"].'</p>
                </div>
                <div class="count-cart">
                <ul  class="input-count-style">
                <li>
                <p iid="'.$row["cart_id"].'" class="count-minus">-</p>
                </li>
                <li>
                <p><input  id="input-id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count-input"  type="text" value="'.$row["cart_count"].'"/></p>
                </li>
                <li>
                <p iid="'.$row["cart_id"].'" class="count-plus">+</p>
                </li>
                </ul>
                </div>
                <div  id="tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> X <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.group_numerals($int).' ₾</p></div>
                <div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="images/bsk_item_del.png" alt=""></a></div>
                <div id="bottom-cart-line"></div>
                </div>';
                    }
                    while ($row = mysqli_fetch_assoc($result));
                    echo '
                        <div id="itog-cont">
                        <h2 class="itog-price">ჯამში : <strong>'.group_numerals($all_price).' </strong> ₾</h2>
                        <p class="button-next"><a class="btn" href="cart.php?action=confirm">შემდეგ</a></p>         
                        </div>';
                }
                else
                {
                    echo '<h3 id="clear-cart">კალათა ცარიელია</h3>';
                }
                break;
        }
        ?>
    </div> <!--/.block__content-->
    <div> <!--//footer-->
        <?php include("include/block-randum.php");
              include("include/service.php");
              include("include/block__footer.php"); ?> <!--block__footer-->
    </div> <!--.//footer-->
</div>  <!--/.igive konteineria container-->
<script src="js/app.js"></script>
</body>
</html>