<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);

    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='tovar.php'> ნივთები</a> \ <a> ნივთის დამატება</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    if ($_POST["submit_add"]) {
        if ($_SESSION['add_tovar'] == '1') {


        $error = array();

        if (!$_POST["form_title"]) {
            $error[] = "მიუთითეთ ნივთის დასახელება";

        }
        if (!$_POST["form_price"]) {
            $error[] = "მიუთითეთ ფასი";

        }
        if (!$_POST["form_category"]) {
            $error[] = "მიუთითეთ კატეგორია";

        } else {
            $result = mysqli_query($link, "SELECT * FROM category WHERE id='{$_POST["form_category"]}'");
            $row = mysqli_fetch_array($result);
            $selectbrand = $row["brand"];
        }

        if ($_POST["chk_visible"]) {
            $chk_visible = "1";
        } else {
            $chk_visible = "0";
        }

        if ($_POST["chk_new"]) {
            $chk_new = "1";
        } else {
            $chk_new = "0";
        }

        if ($_POST["chk_leader"]) {
            $chk_leader = "1";
        } else {
            $chk_leader = "0";
        }

        if ($_POST["chk_sale"]) {
            $chk_sale = "1";
        } else {
            $chk_sale = "0";
        }

        if (count($error)) {
            $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
        } else {
            mysqli_query($link, "INSERT INTO `table_products`(`products_id`, `title`, `price`, `brand`, `seo_words`, `seo_description`, `mini_description`, `images`, `description`, `mini_features`, `features`, `datetime`, `new`, `leader`, `sale`, `visible`, `type_tovara`, `brand_id`, `yes_like`)
VALUES(NULL, '" . $_POST["form_title"] . "',
'" . $_POST["form_price"] . "',
'" . $selectbrand . "',
'" . $_POST["form_seo_words"] . "',
'" . $_POST["form_seo_description"] . "',
'" . $_POST["txt1"] . "',
'" . $_POST["images"] . "',
'" . $_POST["txt2"] . "',
'" . $_POST["txt3"] . "',
'" . $_POST["txt4"] . "',
NOW(),
'" . $chk_new . "',
'" . $chk_leader . "',
'" . $chk_sale . "',
'" . $chk_visible . "',
'" . $_POST["form_type"] . "',
'" . $_POST["form_category"] . "','1')");


            $_SESSION['message'] = "<p id='form-success'>ნივთი დამატებულია!</p>";
            $id = mysqli_insert_id($link);
            if (empty($_POST["upload_image"])) {
                include("actions/upload-image.php");
                unset($_POST["upload_image"]);
            }
            if (empty($_POST["galleryimg"])) {
                include("actions/upload-gallery.php");
                unset($_POST["galleryimg"]);
            }

        }
    }else {
        $msgerror = 'თქვენ არ გაქვთ ნივთის დამატების უფლება!';
    }
}

   ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="js/fancyBox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="jquery_confirm/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="jquery_confirm/script.js"></script>
        <script type="text/javascript" src="jquery_confirm/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="jquery_confirm/ckeditor/AjexFileManager/ajex.js"></script>
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
                <p id="title-page">ნივთის დამატება</p>
            </div>
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
            if (isset($_SESSION['message']))
            {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            if (isset($_SESSION['answer']))
            {
                echo $_SESSION['answer'];
                unset($_SESSION['answer']);
            }
            ?>
            <form  enctype="multipart/form-data" method="post">
                <ul id="edit-tovar">
                    <li><label>ნივთის დასახელება</label><input type="text" name="form_title" /></li>
                    <li><label>ფასი</label><input type="text" name="form_price" /></li>
                    <li><label>კლუჩევიე სიტყვა</label><input type="text" name="form_seo_words" /></li>
                    <li><label>მოკლე აღწერა</label><textarea name="form_seo_description"></textarea></li>
                    <li><label>ნივთის ტიპი</label><select name="form_type" id="type" size="1" >

                            <option value="mobile" >მობილური ტელეფონები</option>
                            <option value="notebook" >ნოუთბუკები</option>
                            <option value="notepad" >პლანშეტები</option>
                        </select></li>
                    <li><label>კატეგორია</label>
                        <select name="form_category" size="10" >
                            <?php
                            $category = mysqli_query($link,"SELECT * FROM category");
                            if (mysqli_num_rows($category) > 0)
                            {
                                $result_category = mysqli_fetch_array($category);
                                do
                                {
                                    echo '<option value="'.$result_category["id"].'">'.$result_category["type"].'-'.$result_category["brand"].'</option><!--droebit chavrte kategoriebis tipebi ro gamochndes-->
                                ';
                                }
                                while ($result_category = mysqli_fetch_array($category));
                            }
                            ?>
                        </select></li>
                </ul>
                <label class="stylelabel"><!--<p class="h3click-img-right"></p>-->ძირითადი სურათი</label>
                <div id="baseimg-upload">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                    <input type="file" name="upload_image" />
                </div>

                <h3 class="h3click">აღწერა ნივთის</h3>
                <div class="div-editor1">
                    <textarea id="editor1" name="txt1" cols="100" rows="20"></textarea>
                    <script type="text/javascript">
                        var ckeditor1 = CKEDITOR.replace("editor1");
                        AjexFileManager.init({
                            returnTo: "ckeditor",
                            editor: ckeditor1
                        });
                    </script>
                </div>
                <h3 class="h3click">ნივთის აღწერა</h3>
                <div class="div-editor2">
                    <textarea id="editor2" name="txt2" cols="100" rows="20"></textarea>
                    <script type="text/javascript">
                        var ckeditor2 = CKEDITOR.replace("editor2");
                        AjexFileManager.init({
                            returnTo: "ckeditor",
                            editor: ckeditor2
                        });
                    </script>
                </div>
                <h3 class="h3click">მოკლე მახასიათებლები</h3>
                <div class="div-editor3">
                    <textarea id="editor3" name="txt3" cols="100" rows="20"></textarea>
                    <script type="text/javascript">
                        var ckeditor3 = CKEDITOR.replace("editor3");
                        AjexFileManager.init({
                            returnTo: "ckeditor",
                            editor: ckeditor3
                        });

                    </script>
                </div>
                <h3 class="h3click">მახასიათებლები</h3>
                <div class="div-editor4">
                    <textarea id="editor4" name="txt4" cols="100" rows="20"></textarea>
                    <script type="text/javascript">
                        var ckeditor4 = CKEDITOR.replace("editor4");
                        AjexFileManager.init({
                            returnTo: "ckeditor",
                            editor: ckeditor4
                        });
                    </script>
                </div>

                <label class="stylelabel">სურათების გალერეა</label>

                <div id="objects">
                    <div id="addimage1" class="addimage">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                        <input type="file" name="galleryimg[]" />
                    </div>
                </div>
                <p id="add-input">დამატება</p>

                <h3 class="h3title">ნივთის პარამეტრები</h3>
                <ul id="checkbox">
                    <li><input type="checkbox" name="chk_visible" id="chk_visible" /><label for="chk_visible">ჩვენება ნივთის</label></li>
                    <li><input type="checkbox" name="chk_new" id="chk_new" /><label for="chk_new">ახალი ნივთი</label></li>
                    <li><input type="checkbox" name="chk_leader" id="chk_leader" /><label for="chk_leader">პოპულარული ნივთები</label></li>
                    <li><input type="checkbox" name="chk_sale" id="chk_sale" /><label for="chk_sale">ნივთი ფასდაკლებით</label></li>
                </ul>

                <p align="right"><input id="submit_form" type="submit" name="submit_add" value="ნივთის დამატება"/></p>
            </form>

        </div>
    </div>
    </body>

    </html>
    <?php
}else {
    header("Location: login.php");
}
?>