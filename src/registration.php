<?php
define('kasius',true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="TrackBar/jQuery/trackbar.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,300i,400,700&display=swap" rel="stylesheet">
    <!--[if lte IE 9]> <link rel="stylesheet" href="css/stylesie9.css"><![endif]-->
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/jcarouserllite_1.0.1.js"></script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="js/check-form.js"></script>
    <script type="text/javascript" src="js/jquery.TextChange.js"></script>
    <script type="text/javascript" src="TrackBar/jQuery/jquery.trackbar.js"></script>
    <title>რეგისტრაცია</title>
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

        <h2 class="h2-title">რეგისტრაცია</h2>
        <form method="post" id="form_reg" action="reg/handler_reg.php">
        <p id="reg_message"></p>
            <div id="block-form-registration">
            <ul id="form-registration">
               <li>
                   <label>შესვლა</label>
                   <span class="star">*</span>
                   <input id="reg_login" type="text" name="reg_login"  class="place">
               </li>
                <li>
                    <label>პაროლი</label>
                    <span class="star">*</span>
                    <input type="text" name="reg_pass" id="reg_pass">
                    <span id="genpass">გენერირება</span>
                </li>
                <li>
                    <label>გვარი</label>
                    <span class="star">*</span>
                    <input type="text" name="reg_surname" id="reg_surname">
                </li>
                <li>
                    <label>სახელი</label>
                    <span class="star">*</span>
                    <input type="text" name="reg_name" id="reg_name">
                </li>
                <li>
                    <label>მამის სახელი</label>
                    <span class="star">*</span>
                    <input type="text" name="reg_patronymic" id="reg_patronymic">
                </li>
                <li>
                    <label>იმეილი</label>
                    <span class="star">*</span>
                    <input type="text" name="reg_email" id="reg_email">
                </li>
                <li>
                    <label>მობილური ტელეფონი</label>
                    <span class="star">*</span>
                    <input type="text" name="reg_phone" id="reg_phone">
                </li>
                <li>
                    <label>მიწოდების ადგილი</label>
                    <span class="star">*</span>
                    <input type="text" name="reg_address" id="reg_address">
                </li>
                <li>
                    <div id="block-captcha">
                        <img src="reg/reg_captcha.php" alt="captcha">
                        <input type="text" name="reg_captcha" id="reg_captcha">
                        <p id="reloadcaptcha" >განახლება</p>
                    </div>
                </li>
            </ul>
            </div>
<div class="btn-reg">
                <p><input type="submit" id="form_submit" value="რეგისტრაცია" name="reg_submit"  class="btn btn-submit" ></p>
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