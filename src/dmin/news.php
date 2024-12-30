<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);
    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='news.php'> სიახლეები</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    if ($_POST["submit_news"])
    {
        if ($_SESSION['add_news'] == '1') {

        if ($_POST["news_title"] == "" || $_POST["news_text"] == "")
        {
            $message = "<p id='form-error'>შეავსეთ ყველა ველი!</p>";
        }else
        {
            mysqli_query($link,"INSERT INTO news(title,text,date)VALUES('".$_POST["news_title"]."','".$_POST["news_text"]."',NOW())");
            $message = "<p id='form-success'>სიახლე დამატებულია!</p>";
        }
    }else
        {
            $msgerror = 'თქვენ არ გაქვთ სიახლის დამატბის ნებართვა!';
        }
    }
    $id = clear_string($_GET["id"]);
    $action = $_GET["action"];
    if (isset($action))
    {
        switch ($action) {

            case 'delete':
                if ($_SESSION['delete_news'] == '1') {
                    $delete = mysqli_query($link, "DELETE FROM news WHERE id='$id'");
                }else
                {
                    $msgerror = 'თქვენ არ გაქვთ სიახლის წაშლის ნებართვა!';
                }
                break;
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
        <script type="text/javascript">
            $(document).ready(function () {
               $(".news").fancybox();
            });
        </script>
        <title>სამართავი პანელი - სიახლეები</title>
    </head>
    <body>
    <div id="block-body">

        <?php
        include("include/block-header.php");
        $all_count = mysqli_query($link,"SELECT * FROM news");
        $result_count = mysqli_num_rows($all_count);
        ?>
        <div id="block-content">
            <div id="block-parameters">
                <p id="count-client">სიახლეები - <strong><?php echo $result_count; ?></strong></p>
                <p align="right" id="add-style"><a class="news" href="#news">დამატება</a></p>
            </div>
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

            if ($message != "") echo $message;


                    $result = mysqli_query($link, "SELECT * FROM news ORDER BY id DESC");
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_array($result);
                        do {
                            echo '<div class="block-news">
                 
                     <h3>'.$row["title"].'</h3>
                     <span>' . $row["date"] . '</span>
                     <p>' . $row["text"] . '</p>
          
                  <p class="links-actions" align="right"><a class="delete" rel="news.php?id='.$row["id"].'&action=delete">წაშლა</a></p>
                    
            </div>';
                        } while ($row = mysqli_fetch_array($result));

            }

            ?>
            <div id="news">
                <form method="post">
                <div id="block-iput">
                    <label>სათაური<input type="text" name="news_title"></label>
                    <label>აღწერა<textarea  name="news_text"></textarea></label>
                </div>
                <p align="right">
                    <input type="submit" name="submit_news" id="submit_news" value="დამატება">
                </p>
                </form>
            </div>

        </div>
    </div>
    </body>

    </html>
    <?php
}else {
    header("location: login.php");
}
?>