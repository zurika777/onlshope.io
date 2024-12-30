<?php
define('kasius',true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");
//unset($_SESSION['auth']); //sesiis gatishva
//setcookie('rememberme','',0, '/'); //cookis gacmenda
if ($_POST["send_message"])
{
    $error = array();
    if (!$_POST["feed_name"]) $error[] = "მიუთითეთ თქვენი სახელი";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($_POST["feed_email"])))
    {
        $error[] = "მიუთითეთ სწორი მეილი";
    }
    if (!$_POST["feed_subject"]) $error[] = "მიუთითეთ თემის სათაური";
    if (!$_POST["feed_name"]) $error[] = "მიუთითეთ ტექსტური შეტყობინება";

    if (strtolower($_POST["reg_captcha"]) != $_SESSION['img_captcha'])
    {
    $error[] = "სურათის კოდი არასწორია";

    }
    if (count($error))
    {
        $_SESSION['message'] = "<p id='form-error'>".implode('<br/>',$error)."</p>";
    }else
    {
        send_mail($_POST["feed_email"],'rcmodelebi@gmail.com',$_POST["feed_subject"],'დან:' .$_POST["feed_name"].'<br/>'.$_POST["feed_text"]);
        $_SESSION['message'] = "<p id='form-success'>თქვენი წერილი წარმატებისთ გაიგზავნა!</p>";
    }
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

    <title>psop</title>
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
        <h2 class="h2-title">კონტაქტი</h2>
        <?php
        if (isset($_SESSION['message']))
        {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>

        <form method="post" >
            <div id="block-feedback">
                <ul id="feedback">
                    <li>
                        <label>თქვენი სახელი</label>
                        <input type="text" name="feed_name">
                    </li>
                    <li>
                        <label>თქვენი მეილი</label>
                        <input type="text" name="feed_email">
                    </li>
                    <li>
                        <label>თემა</label>
                        <input type="text" name="feed_subject">
                    </li>
                    <li>
                        <label>ტექსტურლი შეტყობინება</label>
                        <textarea name="feed_text"></textarea>
                    </li>

                    <li>
                        <label for="reg_captcha">დამცავი კოდი</label>
                        <div id="block-captcha">
                            <img src="reg/reg_captcha.php" alt="captcha">
                            <input type="text" name="reg_captcha" id="reg_captcha">
                            <p id="reloadcaptcha" >განახლება</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="btn-reg">
                <p><input type="submit" id="form_submit"  name="send_message"  class="btn btn-submit" ></p>
            </div>
        </form>

    </div> <!--/.block__content-->


    <div> <!--//footer-->
        <?php include("include/block-randum.php");
              include("include/service.php");
              include("include/block__footer.php"); ?> <!--block__footer-->
    </div> <!--//footer-->
</div>  <!--/.igive konteineria container-->

<script src="js/app.js"></script>
</body>
</html>