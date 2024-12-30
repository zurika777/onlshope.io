<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);

    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href ='index.php'>მთავარი</a> \ <a href ='category.php'>კატეგორიები</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    if ($_POST["submit_cat"]) {
        if ($_SESSION['add_category'] == '1') {

            $error = array();
            if (!$_POST["cat_type"]) $error[] = "მიუთითეთ ნივთის მოდელი";
            if (!$_POST["cat_brand"]) $error[] = "მიუთითეთ კატეგორიის დასახელება";
            if (count($error)) {
                $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
            } else {
                $cat_type = clear_string($_POST["cat_type"]);
                $cat_brand = clear_string($_POST["cat_brand"]);
                mysqli_query($link, "INSERT INTO `category`(`id`, `type`, `brand`)VALUES(NULL,'" . $cat_type . "','" . $cat_brand . "')");
                $_SESSION['message'] = "<p id='form-success'>კატეგორია დამატებულია!</p>";
            }
        }else
        {
            $msgerror = 'თქვენ არ გაქვთ კატეგორიის დამატების ნებართვა!';
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
        <link href="js/fancyBox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="jquery_confirm/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="jquery_confirm/jquery.confirm.js"></script>
        <script type="text/javascript" src="jquery_confirm/script.js"></script>
        <script type="text/javascript" src="js/fancyBox/source/jquery.fancybox.js"></script>
        <title>სამართავი პანელი</title>
    </head>
    <body>
    <div id="block-body">

        <?php
        include("include/block-header.php");
        ?>
        <div id="block-content">
            <div id="block-parameters">
                <p id="title-page">კატეგორიები</p>
            </div>
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
            if (isset($_SESSION['message']))
            {
                echo $_SESSION['message'];
                unset ($_SESSION['message']);
            }
            ?>
                <form method="POST">
                    <ul id="cat_products">
                        <li>
                            <label>კატეგორიები</label>
                            <div>
                                <?php
                                if ($_SESSION['delete_category'] == '1')
                                {
                                   echo '<a class="delete-cat">წაშლა</a>';
                                }
                                ?>

                                <?php if ($_SESSION['delete_category'] == '1') {
                                    echo '';
                                }
                                ?>
                            </div>
                            <select name="cat_type" id="cat_type" size="10" >
                                <?php
                                $result = mysqli_query($link,"SELECT * FROM category ORDER BY type DESC");
                                if (mysqli_num_rows($result) > 0)
                                {
                                $row = mysqli_fetch_array($result);
                                do {
                                    echo '<option  value="' . $row["id"] . '" >' . $row["type"] . ' - ' . $row["brand"] . '</option>';
                                }while ($row = mysqli_fetch_array($result));
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label>ნივთის ტიპი მ.mob</label>
                            <input type="text" name="cat_type" />
                        </li>
                        <li>
                            <label>მოდელი, მაგ: Nokia</label>
                            <input type="text" name="cat_brand" />
                        </li>
                    </ul>
                    <p align="right"><input type="submit" name="submit_cat" id="submit_form" value="კატეგორიის დამატება" /></p>
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