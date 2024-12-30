<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);
    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='administrators.php'> ადმინები</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    $id = clear_string($_GET["id"]);
    $action = $_GET["action"];
    if (isset($action))
    {
        switch ($action) {
            case 'delete':
                if ($_SESSION['auth_admin_login'] == 'admin')
                {
                 $delete = mysqli_query($link,"DELETE FROM reg_admin WHERE id='$id'");
                }else
                    {
                        $msgerror = 'თქვენ არ გაქვთ ადმინისტრატორის წაშლის ნებართვა!';
                    }
                break ;
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
        <title>სამართავი პანელი - მომხმარებლები</title>
    </head>
    <body>
    <div id="block-body">

        <?php
        include("include/block-header.php");

        $all_client = mysqli_query($link,"SELECT * FROM reg_admin");
        $result_count = mysqli_num_rows($all_client);
        ?>
        <div id="block-content">
            <div id="block-parameters">
                <p id="title-page">ადმინები - <strong><?php echo $result_count; ?></strong></p>
                <p align="right" id="add-style"><a class="news" href="add_administrators.php">ადმინის დამატება</a></p>
            </div>
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
            if ($_SESSION['view_admin'] == '1')
            {

            $result = mysqli_query($link,"SELECT * FROM reg_admin ORDER BY id DESC");
            if (mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                do {
                    echo '
            <ul id="list-admin">
            <li>
            <h3>' . $row["fio"] . '</h3>
            <p><strong>წოდება</strong> - '.$row["role"].'</p>
            <p><strong>მეილი</strong> - '.$row["email"].'</p>
            <p><strong>ტელეფონი</strong> - '.$row["phone"].'</p>
            <p class="links-actions" align="right"><a class="green" href="edit_administrators.php?id='.$row["id"].'">შეცვლა</a> | <a class="delete" rel="administrators.php?id='.$row["id"].'&action=delete">წაშლა</a></p>
</li>
            
</ul>     
            ';
                }while($row = mysqli_fetch_array($result));

            }

            }else
            {
                echo '<p id="form-error" align="center">თქვენ არ გაქვთ ადმინისტრაორების ნახვის ნებართვა!</p>';
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