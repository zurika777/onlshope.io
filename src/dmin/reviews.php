<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);

    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='reviews.php'> კომენტარები</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    $id =clear_string($_GET["id"]);
    $sort =$_GET["sort"];
    switch ($sort) {
        case 'accept':

         $sort = "moderat='1' DESC";
         $sort_name = 'შემოწმებული';
         break;
        case 'no-accept':
            $sort = "moderat='0' DESC";
            $sort_name = 'შეუმოწმებელი';
            break;
        default:
            $sort = "reviews_id DESC";
            $sort_name = 'სორტირების გარეშე';
            break;
    }
    $action = ($_GET["action"]);
    if (isset($action))
    {
        switch ($action) {
            case 'accept':
                if ($_SESSION['accept_reviews'] == '1')
                {

                $update = mysqli_query($link,"UPDATE table_reviews SET moderat='1' WHERE reviews_id='$id'");
                }else{
                    $msgerror = 'თქვენ არ გაქვთ კომენტარის დამტკიცების ნებართვა!';
                }
                break;
            case 'delete':
                if ($_SESSION['delete_reviews'] == '1')
                {

                $update = mysqli_query($link,"DELETE FROM table_reviews  WHERE reviews_id='$id'");
                }else{
                    $msgerror = 'თქვენ არ გაქვთ კომენტარის წაშლის ნებართვა!';
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
        <title>კომენტარები</title>
    </head>
    <body>
    <div id="block-body">

    <?php
    include("include/block-header.php");
    $all_count = mysqli_query($link, "SELECT * FROM table_reviews");
    $all_count_result = mysqli_num_rows($all_count);
    $no_accept_count = mysqli_query($link, "SELECT * FROM table_reviews WHERE moderat = '0'");
    $no_accept_count_result = mysqli_num_rows($no_accept_count);
    ?>
    <div id="block-content">
    <div id="block-parameters">
        <ul id="options-list">
            <p id="title-page">კომენტარი</p>
        <li>სორტირება</li>
        <li><a id="select-links" href="#"><? echo $sort_name; ?></a>
            <ul id="list-links-sort">
                <li><a href="reviews.php?sort=accept">შემოწმებული</a></li>
                <li><a href="reviews.php?sort=no-accept">შეუმოწმებელი</a></li>

            </ul>
        </li>
        </ul>
    </div>
    <div id="block-info">
        <ul id="review-info-count">
            <li>სულ კომენტარი - <strong><?php echo $all_count_result; ?></strong></li>
            <li>შეუმოწმებელი კომენტარი - <strong><?php echo $no_accept_count_result; ?></strong></li>

        </ul>
    </div>
    <?php
    if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
    $num = 8;
    $page = strip_tags($_GET['page']);
    //$page = $link ->real_escape_string($page);
    //$page = mysqli_real_escape_string($page);
    $page = mysqli_real_escape_string($link,$page);

    $count = mysqli_query($link, "SELECT COUNT(*) FROM table_reviews");
    $temp = mysqli_fetch_array($count);
    $post = $temp[0];
    $total = (($post - 1) / $num) + 1;
    $total = intval($total);
    $page = intval($page);

    if (empty($page) or $page < 0) $page = 1;
    if ($page > $total) $page = $total;

    $start = $page * $num - $num;
    if ($temp[0] > 0) {
        $result = mysqli_query($link, "SELECT * FROM table_reviews,table_products WHERE table_products.products_id = table_reviews.products_id ORDER BY $sort LIMIT $start, $num");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            do {
                if (strlen($row["images"]) > 0 && file_exists("../uploads_images/" . $row["images"])) {
                    $img_path = '../uploads_images/' . $row["images"];
                    $max_width = 150;
                    $max_height = 150;
                    list($width, $height) = getimagesize($img_path);
                    $ratioh = $max_height / $height;
                    $ratiow = $max_width / $width;
                    $ratio = min($ratioh, $ratiow);
                    $width = intval($ratio * $width);
                    $height = intval($ratio * $height);
                } else {
                    $img_path = "images/no-image.png";
                    $width = 100;
                    $height = 182;
                }
                if ($row["moderat"] == '0') {
                    $link_accept = '<a class="green" href="reviews.php?id=' . $row['reviews_id'] . '&action=accept">დამტკიცება</a>  | ';
                } else {
                    $link_accept = '';
                }

                echo '<div class="block-reviews">
                    <div class="block-title-img">
                        <p>' . $row["title"] . '</p>
                        <img src="' . $img_path . '" width="' . $width . '" height="' . $height . '" />
                    </div>
                    <p class="author-date"><strong>' . $row["name"] . '</strong> ' . $row["date"] . '</p>
                    <div class="plus-minus">
                        <img src="images/plus16.png" /><p>' . $row["good_reviews"] . '</p>
                        <img src="images/minus16.png" /><p>' . $row["bad_reviews"] . '</p>
                    </div>

                    <p class="reviews-comment" >' . $row["comment"] . '</p>
                    <p class="links-actions" align="right" >' . $link_accept . '<a class="delete" rel="reviews.php?id=' . $row['reviews_id'] . '&action=delete">წაშლა</a></p>
            </div>';

            } while ($row = mysqli_fetch_array($result));
        }

    }

if ($page != 1){ $pervpage = '<li><a class="pstr-prev" href="reviews.php?page='.($page - 1).'">&lt;</a></li>';}
if ($page != $total)  $nextpage = '<li><a class="pstr-next" href="reviews.php?page='.($page + 1).'">&gt;</a></li>';


if ($page - 5 > 0) $page5left = '<li><a href="reviews.php?page='.($page - 5).'">'.($page - 5).'</a></li>';
if ($page - 4 > 0) $page4left = '<li><a href="reviews.php?page='.($page - 4).'">'.($page - 4).'</a></li>';
if ($page - 3 > 0) $page3left = '<li><a href="reviews.php?page='.($page - 3).'">'.($page - 3).'</a></li>';
if ($page - 2 > 0) $page2left = '<li><a href="reviews.php?page='.($page - 2).'">'.($page - 2).'</a></li>';
if ($page - 1 > 0) $page1left = '<li><a href="reviews.php?page='.($page - 1).'">'.($page - 1).'</a></li>';


if ($page + 5 <= $total) $page5right = '<li><a href="reviews.php?page='.($page + 5).'">'.($page + 5).'</a></li>';
if ($page + 4 <= $total) $page4right = '<li><a href="reviews.php?page='.($page + 4).'">'.($page + 4).'</a></li>';
if ($page + 3 <= $total) $page3right = '<li><a href="reviews.php?page='.($page + 3).'">'.($page + 3).'</a></li>';
if ($page + 2 <= $total) $page2right = '<li><a href="reviews.php?page='.($page + 2).'">'.($page + 2).'</a></li>';
if ($page + 1 <= $total) $page1right = '<li><a href="reviews.php?page='.($page + 1).'">'.($page + 1).'</a></li>';


if ($page+5 < $total)
{
    //$strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_cat.php?$'.$catlink.'&type='.$type.'&sort='.$_GET["sort"].'&page='.$total.'">'.$total.'</a></li>';
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="reviews.php?page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = "";
}
if ($total > 1) {
    echo '<div class="pstrnav"><ul>';

    /*echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='''view_cat.php?'.$catlink.'cat='.$cat.'&type='.$type.'page=".$page."'''>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;*/ //es iyo ratom ar vici
    echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='index.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
    echo ' 
                </ul>
                </div>
                ';

    // echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='view.cat.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    // echo '
    //</ul>
    //</div>
    //';
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