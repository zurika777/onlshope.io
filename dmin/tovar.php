<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);

    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='tovar.php'> ნივთები</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    $cat = $_GET["cat"];
    $type = $_GET["type"];

    if (isset($cat))
    {
        switch ($cat){
            case 'all':

                $cat_name = "ყველა ნივთი";
                $url = "cat=all&";
                $cat = "";
                break;
            case 'mobile':
                $cat_name = "მობილური ტელეფონები";
                $url = "cat=mobile&";
                $cat = "WHERE type_tovara='mobile'";
                break;
            case 'notebook':
                $cat_name = "ნოუთბუქები";
                $url = "cat=notebook&";
                $cat = "WHERE type_tovara='notebook'";
                break;
            case 'notepad':
                $cat_name = "პლანშეტები";
                $url = "cat=notepad&";
                $cat = "WHERE type_tovara='notepad'";
                break;
            default:
                $cat_name = $cat;
                $url = "type".clear_string($type)."&cat=".clear_string($cat)."&";
                $cat = "WHERE type_tovara='".clear_string($type)."' AND brand='".clear_string($cat)."'";
                break;
        }
    }
    else{
        $cat_name = "ყველა ნივთი";
        $url = "";
        $cat = "";

    }

    $action = $_GET["action"];
    if (isset($action))
    {
        $id = (int)$_GET["id"];
        switch ($action)
        {
            case 'delete':
                if ($_SESSION['delete_tovar'] == '1')
                {
                    $delete = mysqli_query($link, "DELETE FROM table_products WHERE products_id='$id'");
                }else{
                    $msgerror = 'თქვენ არ გაქვთ ამ ნივთის წაშლის ნებართვა!';
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
        $all_count = mysqli_query($link,"SELECT * FROM table_products");
        $all_count_result = mysqli_num_rows($all_count);
        ?>
        <div id="block-content">
            <div id="block-parameters">
            <ul id="options-list">
                <p id="title-page">ნივთები</p>
                <li><a id="select-links" href="#"><? echo $cat_name; ?></a>
                <div id="list-links">
                 <ul>
                     <li><a href="tovar.php?cat=all"><strong>ყველა ნივთი</strong></a></li>
                    <li><a href="tovar.php?cat=mobile"><strong>ტელეფონები</strong></a></li>
                     <?php
                     $result1 = mysqli_query($link,"SELECT * FROM category WHERE type='mobile'");
                     if (mysqli_num_rows($result1) > 0)
                     {
                         $row1 =mysqli_fetch_array($result1);
                         do
                         {
                            echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
                         }while ($row1 = mysqli_fetch_array($result1));
                     }
                     ?>
                 </ul>
                    <ul>
                        <li><a href="tovar.php?cat=notebook"><strong>ნოუთბუქები</strong></a></li>
                        <?php
                        $result1 = mysqli_query($link,"SELECT * FROM category WHERE type='notebook'");
                        if (mysqli_num_rows($result1) > 0)
                        {
                            $row1 =mysqli_fetch_array($result1);
                            do
                            {
                                echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
                            }while ($row1 = mysqli_fetch_array($result1));
                        }
                        ?>
                    </ul>
                    <ul>
                        <li><a href="tovar.php?cat=notepad"><strong>პლანშეტები</strong></a></li>
                        <?php
                        $result1 = mysqli_query($link,"SELECT * FROM category WHERE type='notepad'");
                        if (mysqli_num_rows($result1) > 0)
                        {
                            $row1 =mysqli_fetch_array($result1);
                            do
                            {
                                echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
                            }while ($row1 = mysqli_fetch_array($result1));
                        }
                        ?>

                 </ul>

                </div>

                </li>
            </ul>
            </div>
            <div id="block-info">
                <p id="count-style">საერთო ჯამში ნივთი - <strong><?php echo $all_count_result; ?></strong> </p>
                <p id="add-style"><a href="add_product.php">დამატება</a></p>
            </div>
            <ul id="block-tovar">
                <?php
                if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
                $num = 6;
                $page = (int)$_GET['page'];
                $count = mysqli_query($link,"SELECT COUNT(*) FROM table_products $cat");
                $temp = mysqli_fetch_array($count);
                $post = $temp[0];
                $total = (($post - 1) / $num) + 1;
                $total = intval($total);
                $page = intval($page);
                if (empty($page) or $page < 0) $page = 1;
                if ($page > $total) $page = $total;
                $start = $page * $num - $num;

                if ($temp[0] > 0)
                {
                    $result = mysqli_query($link,"SELECT * FROM table_products $cat ORDER BY products_id DESC LIMIT $start, $num");
                    if (mysqli_num_rows($result) > 0)
                    {
                        $row = mysqli_fetch_array($result);
                        do
                        {
                            if (strlen($row["images"]) > 0 && file_exists("../uploads_images/".$row["images"]))
                            {
                                $img_path = '../uploads_images/' .$row["images"];
                                $max_width = 160;
                                $max_height = 160;
                                list($width, $height) = getimagesize($img_path);
                                $ratioh = $max_height/$height;
                                $ratiow = $max_width/$width;
                                $ratio  = min($ratioh, $ratiow);
                                $width  = intval($ratio*$width);
                                $height = intval($ratio*$height);
                            }else {
                                $img_path = "images/no-image.png";
                                $width = 90;
                                $height = 164;
                            }
                            echo '<li>
    <p>'.$row["title"].'</p>
    <div>
  <img class="block-tavar-img" src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
</div>
<p class="link-action">
<a class="green" href="edit-product.php?id='.$row["products_id"].'">შეცვლა</a> | <a rel="tovar.php?'.$url.'id='.$row['products_id'].'&action=delete" class="delete">წაშლა</a>
</p>
</li>';
             }
            while ($row = mysqli_fetch_array($result));
                    echo '
                    </ul>
                    ';

                        }

                    }
                if ($page != 1){ $pervpage = '<li><a class="pstr-prev" href="tovar.php?'.$url.'page='.($page - 1).'">&lt;</a></li>';}
                if ($page != $total)  $nextpage = '<li><a class="pstr-next" href="tovar.php?'.$url.'page='.($page + 1).'">&gt;</a></li>';


                if ($page - 5 > 0) $page5left = '<li><a href="tovar.php?'.$url.'page='.($page - 5).'">'.($page - 5).'</a></li>';
                if ($page - 4 > 0) $page4left = '<li><a href="tovar.php?'.$url.'page='.($page - 4).'">'.($page - 4).'</a></li>';
                if ($page - 3 > 0) $page3left = '<li><a href="tovar.php?'.$url.'page='.($page - 3).'">'.($page - 3).'</a></li>';
                if ($page - 2 > 0) $page2left = '<li><a href="tovar.php?'.$url.'page='.($page - 2).'">'.($page - 2).'</a></li>';
                if ($page - 1 > 0) $page1left = '<li><a href="tovar.php?'.$url.'page='.($page - 1).'">'.($page - 1).'</a></li>';


                if ($page + 5 <= $total) $page5right = '<li><a href="tovar.php?'.$url.'page='.($page + 5).'">'.($page + 5).'</a></li>';
                if ($page + 4 <= $total) $page4right = '<li><a href="tovar.php?'.$url.'page='.($page + 4).'">'.($page + 4).'</a></li>';
                if ($page + 3 <= $total) $page3right = '<li><a href="tovar.php?'.$url.'page='.($page + 3).'">'.($page + 3).'</a></li>';
                if ($page + 2 <= $total) $page2right  = '<li><a href="tovar.php?'.$url.'page='.($page + 2).'">'.($page + 2).'</a></li>';
                if ($page + 1 <= $total) $page1right  = '<li><a href="tovar.php?'.$url.'page='.($page + 1).'">'.($page + 1).'</a></li>';


                if ($page+5 < $total)
                {
                    //$strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_cat.php?$'.$catlink.'&type='.$type.'&sort='.$_GET["sort"].'&page='.$total.'">'.$total.'</a></li>';
                    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="tovar.php?'.$url.'page='.$total.'">'.$total.'</a></li>';
                }else
                {
                    $strtotal = "";
                }
                ?>
                <div id="footerfix"></div>
                <?php
                {
                    echo '<div class="pstrnav">
                    <ul>';
                    // echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='''view_cat.php?'.$catlink.'cat='.$cat.'&type='.$type.'page=".$page."'''>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
                    //echo '
                    //</ul>
                    //</div>
                    // ';
                    echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='index.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
                    echo '
                    </ul>
                        </div>
                       ';
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