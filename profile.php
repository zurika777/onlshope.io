<?php
define('kasius',true);
session_start();
/*error_reporting( E_ALL);*/
/*ini_set("display_errors", 1);
error_reporting(-1);*/


//unset($_SESSION['auth']); //sesiis gatishva
//setcookie('rememberme','',0, '/'); //cookis gacmenda
if ($_SESSION['auth'] == true )
{
include("include/db_connect.php");
include("functions/functions.php");

        if ($_POST["save_submit"])
        {
            $_POST["info_surname"] = clear_string($_POST["info_surname"]);
            $_POST["info_name"] = clear_string($_POST["info_name"]);
            $_POST["info_patronymic"] = clear_string($_POST["info_patronymic"]);
            $_POST["info_email"] = clear_string($_POST["info_email"]);
            $_POST["info_phone"] = clear_string($_POST["info_phone"]);
            $_POST["info_address"] = clear_string($_POST["info_address"]);


            $error = array();

            $pass = md5($_POST["info_pass"]);
            $pass = strrev($pass);
            $pass = "9nm2rv8q".$pass."2yo6z";

            if ($_SESSION['auth_pass'] != $pass)
            {
                $error[] = 'პაროლი არასწორია!';
            } else {
                if ($_POST["info_new_pass"] != "")
                {
                    if (strlen($_POST["info_new_pass"]) < 7 || strlen($_POST["info_new_pass"]) > 15) {
                        $error[] = 'მიუთითთ ახალი პაროლი 7 დან 15 სიმბოლომდე!';
                    } else
                        {
                        $newpass = md5(clear_string($_POST["info_new_pass"]));
                        $newpass = strrev($newpass);
                        $newpass = "9nm2rv8q".$newpass."2yo6z";
                        $newpassquery = "pass='".$newpass."',";
                    }
                }

                if (strlen($_POST["info_surname"]) < 3 || strlen($_POST["info_surname"]) > 15) {
                    $error[] = 'მიუთითეთ გვარილი 3 დან 15 სიმბოლომდე!';
                }
                if (strlen($_POST["info_name"]) < 3 || strlen($_POST["info_name"]) > 15) {
                    $error[] = 'მიუთითეთ სახელი 3 დან 15 სიმბოლომდე!';
                }
                if (strlen($_POST["info_patronymic"]) < 3 || strlen($_POST["info_patronymic"]) > 25) {
                    $error[] = 'მიუთითეთ მამის სახელი 3 დან 25 სიმბოლომდე!';
                }
                if (strlen($_POST["info_email"]) == "") {
                    $error[] = 'მიუთითეთ E-mail!';
                } else if (!preg_match("|^[-a-z0-9_\.]+\@[-a-z0-9_\.]+\.[a-z]{2,6}$|i",trim($_POST["info_email"]))) {
                    $error[] = 'მიუთითეთ სწორი E-mail!';
                }
                if (strlen($_POST["info_address"]) == "") {
                    $error[] = 'მიუთითეთ მიწოდების ადგილის მისამართი!';
                }
                if (strlen($_POST["info_phone"]) == "") {
                    $error[] = 'მიუთითეთ ტელეფონის ნომერი!';
                }
            }
            if (count($error)) {
                $_SESSION['msg'] = "<p  id='form-error'>".implode('<br />',$error)."</p>";
            } else {
                $_SESSION['msg'] = "<p  id='form-success'>მონაცემები  შენახულია!</p>";



               $dataquery = $newpassquery."surname='".$_POST["info_surname"]."',name='".$_POST["info_name"]."',patronymic='".$_POST["info_patronymic"]."',email='".$_POST["info_email"]."',phone='".$_POST["info_phone"]."',address='".$_POST["info_address"]."'";
                    $update = mysqli_query($link,"UPDATE  reg_user SET $dataquery WHERE login ='{$_SESSION['auth_login']}'");

   if ($newpass){ $_SESSION['auth_pass'] = $newpass;}

                $_SESSION['auth_surname'] = $_POST["info_surname"];
                $_SESSION['auth_name'] = $_POST["info_name"];
                $_SESSION['auth_patronymic'] = $_POST["info_patronymic"];
                $_SESSION["info_email"] = $_POST["info_email"];
                $_SESSION["info_phone"] = $_POST["info_phone"];
                $_SESSION["info_address"] = $_POST["info_address"];

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
        <h3 class="h3-title" >პროფილის რედაქტირება</h3>
        <?php
        if (isset($_SESSION['msg']) && $_SESSION['msg']) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" id="form_profile">
            <ul id="info-profile">
                <li>
                    <label for="info_pass">მიმდინარე პაროლი</label>
                    <span class="star">*</span>
                    <input type="text" name="info_pass" id="info_pass" />
                </li>
                <li>
                    <label for="info_new_pass">ახალი პაროლი</label>
                    <span class="star"></span>
                    <input type="text" name="info_new_pass" id="info_new_pass" />
                </li>
                <li>
                    <label for="info_surname">გვარი</label>
                    <span class="star">*</span>
                    <input type="text" name="info_surname" id="info_surname" value="<?php echo $_SESSION['auth_surname']; ?>" />
                </li>
                <li>
                    <label for="info_name">სახელი</label>
                    <span class="star">*</span>
                    <input type="text" name="info_name" id="info_name" value="<?php echo $_SESSION['auth_name']; ?>"  />
                </li>
                <li>
                    <label for="info_patronymic">მამის სახელი</label>
                    <span class="star">*</span>
                    <input type="text" name="info_patronymic" id="info_patronymic" value="<?php echo $_SESSION['auth_patronymic']; ?>"  />
                </li>
                <li>
                    <label for="info_email">Email</label>
                    <span class="star">*</span>
                    <input type="text" name="info_email" id="info_email" value="<?php echo $_SESSION['auth_email']; ?>"  />
                </li>
                <li>
                    <label for="info_phone">მობილური ტელეფონი</label>
                    <span class="star">*</span>
                    <input type="text" name="info_phone" id="info_phone" value="<?php echo $_SESSION['auth_phone']; ?>"  />
                </li>
                <li>
                    <label for="info_address">მიწოდების ადგილი</label>
                    <span class="star">*</span>
                    <textarea id="info_address" name="info_address"><?php echo $_SESSION['auth_address']; ?></textarea>
                </li>
            </ul>
            <p align="right">
                <input type="submit" id="form_submit" value="დამახსოვრება" name="save_submit" class="btn btn-submit"/>
            </p>
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
<?php
}else {
    { header ("location: index.php"); } //tu ar aris avtorizebuli uzeri im shemtxvevashi gadaagdos indexphp gverdze
}
?>