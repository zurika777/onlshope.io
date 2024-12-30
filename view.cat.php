<?php
define('kasius',true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");

$cat = clear_string($_GET["cat"]);
$type = clear_string($_GET["type"]);
$sorting = $_GET["sort"];

switch ($sorting)
{
    case 'price-asc':
        $sorting = 'price ASC';
        $sort_name = 'იაფიანიდან ძვირამდე';
        break;

    case 'price-desc':
        $sorting = 'price DESC';
        $sort_name = 'ძვირიანიდან იაფამდე';
        break;

    case 'popular':
        $sorting = 'count DESC';
        $sort_name = 'პოპულარული';
        break;

    case 'news':
        $sorting = 'datetime DESC';
        $sort_name = 'ახლები';
        break;

    case 'brand':
        $sorting = 'brand ASC';
        $sort_name = 'ა დან ბ მდე';
        break;

    default:
        $sorting = 'products_id ASC';
        $sort_name = 'სორტირების გარეშე';
        break;


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
            <?php
            if (!empty($cat) && !empty($type))
            {
                $querycat= "AND brand='$cat' AND type_tovara='$type'";
                $catlink= "cat=$cat&";
            }else
            {
               if (!empty($type))
               {
                   $querycat= "AND type_tovara='$type'";
               }else
               {
                   $querycat = "";
               }
                if (!empty($cat))
                {
                    $catlink= "cat='$cat&";
                }else
                {
                    $catlink = "";
                }
            }
            $num = 8;  // aq vutitebt ramdeni gvinda rom ganovitanot
            $page =  $_GET['page'];

            $count = mysqli_query($link,"SELECT COUNT(*) FROM  table_products  WHERE visible='1' $querycat");
            $temp = mysqli_fetch_array($count);
            if ($temp[0] > 0)
            {
                $tempcount = $temp[0];
                $total = (($tempcount - 1) / $num) + 1;
                $total = intval($total);

                $page = intval($page);

                if (empty($page) or $page < 0) $page = 1;
                if ($page > $total) $page = $total;
                $start = $page * $num - $num;
                $qury_start_num = " LIMIT $start, $num";
            }
            $result = mysqli_query($link,"SELECT * FROM  table_products WHERE visible='1' $querycat ORDER BY $sorting $qury_start_num") ;
            if (mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);

                echo '
        <div class="block-sorting"><!--block__sorting-->
            <p class="nav-breadcrumbs"><a class="nav-breadcrumbs-link" href="index.php">მთავარი</a> \ <span class="nav-breadcrumbs-link">ყველა ნივთი</span></p>
            <div class="options-list">
                <div><img id="style-grid" src="images/icon-grid.svg" width="24" height="24" alt="img"></div>
                <div><img id="style-list"  src="images/icon-list.svg" width="24" height="24" alt="img"></div>
                <div class="sort-sort">სორტირება:</div>
                <div><a id="select-sort" href="#">'.$sort_name.'</a></div>
                <div id="sorting-list">

                    <div><a class="select-sort" href="view.cat.php?'.$catlink.'$type='.$type.'&sort=price-asc">იაფიანიდან ძვირამდე</a></div>
                    <div><a class="select-sort" href="view.cat.php?'.$catlink.'$type='.$type.'&sort=price-desc">ძვირიანიდან იაფამდე</a></div>
                    <div><a class="select-sort" href="view.cat.php?'.$catlink.'$type='.$type.'&sort=popular">პოპულარული</a></div>
                    <div><a class="select-sort" href="view.cat.php?'.$catlink.'$type='.$type.'&sort=news">ახლები</a></div>
                    <div><a class="select-sort" href="view.cat.php?'.$catlink.'$type='.$type.'&sort=brand">ა დან ბ მდე</a></div>

                </div>
            </div>

        </div> <!--/.block__sorting-->
<ul id="block__tovar-grid">';
                do
                {
                    if ($row["images"] != "" && file_exists("uploads_images/".$row["images"]))
                    {
                        $img_path = 'uploads_images/' .$row["images"];
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
                        $width = 88;
                        $height = 88;
                    }
                    $query_reviews = mysqli_query($link,"SELECT * FROM table_reviews WHERE products_id='{$row["products_id"]}' AND moderat='1'");
                    $count_reviews = mysqli_num_rows($query_reviews);//komentaris da naxvebis gamotanis
                    echo '
  <li>
  <div id="block__images-grid"><a href="view_content.php?id='.$row["products_id"].'">
  <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a>
</div>
<p id="style__title-grid"><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
<ul id="reviews__and-count-grid">
<li><img src="uploads_images/vote.svg" height="20" width="20" alt=""><p>'.$row["count"].'</p></li>
<li><img src="uploads_images/chat.svg"  height="20" width="20"alt=""><p>'.$count_reviews.'</p></li>
</ul>

<p class="style__price-grid"><strong class="style__price-grid-strong">'.group_numerals($row["price"]).'</strong> ₾</p>
<div class="mini__features">'.$row["mini_features"].'</div>
<a class="add__cart-style-grid" href="#" tid="'.$row["products_id"].'"></a>

</li>';
                }
                while ($row = mysqli_fetch_array($result));
            ?>
        </ul>

        <ul id="block__tovar-list">
            <?php
            $result = mysqli_query($link,"SELECT * FROM  table_products WHERE visible='1' $querycat ORDER BY $sorting $qury_start_num") ;
            if (mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                do
                {
                    if ($row["images"] != "" && file_exists("uploads_images/".$row["images"]))
                    {
                        $img_path = 'uploads_images/' .$row["images"];
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
                        $width = 88;
                        $height = 88;
                    }
                    $query_reviews = mysqli_query($link,"SELECT * FROM table_reviews WHERE products_id='{$row["products_id"]}' AND moderat='1'");
                    $count_reviews = mysqli_num_rows($query_reviews);//komentaris da naxvebis gamotanis
                    echo '
  <li>
  <div id="block__images-list"><a href="view_content.php?id='.$row["products_id"].'">
  <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a>
</div>

<ul id="reviews__and-counts-list">
<li><img src="uploads_images/vote.svg" height="20" width="20" alt=""><p>'.$row["count"].'</p></li>
<li><img src="uploads_images/chat.svg"  height="20" width="20"alt=""><p>'.$count_reviews.'</p></li>
</ul>

<p id="style__title-list"><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>

<a class="add__cart-style-list" href="#" tid="'.$row["products_id"].'"></a>
<p class="style__price-list"><strong class="style__price-list-strong">'.group_numerals($row["price"]).'</strong> ₾</p>

<div class="style-text-list">'.$row["mini_description"].'</div>
</li>';
                }
                while ($row = mysqli_fetch_array($result));
            }
            }
             else {
                echo '<h3>კატეგორია არ არსებობს ან არ შექმნილა!</h3>';
            }
            echo '</ul>';
            if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="view.cat.php?page='.($page - 1).'">&lt;</a></li>';}
            if ($page != $total)  $pstr_next = '<li><a class="pstr-next" href="view.cat.php?page='.($page + 1).'">&gt;</a></li>';


            if ($page - 5 > 0) $page5left = '<li><a href="view.cat.php?page='.($page - 5).'">'.($page - 5).'</a></li>';
            if ($page - 4 > 0) $page4left = '<li><a href="view.cat.php?page='.($page - 4).'">'.($page - 4).'</a></li>';
            if ($page - 3 > 0) $page3left = '<li><a href="view.cat.php?page='.($page - 3).'">'.($page - 3).'</a></li>';
            if ($page - 2 > 0) $page2left = '<li><a href="view.cat.php?page='.($page - 2).'">'.($page - 2).'</a></li>';
            if ($page - 1 > 0) $page1left = '<li><a href="view.cat.php?page='.($page - 1).'">'.($page - 1).'</a></li>';


            if ($page + 5 <= $total) $page5right = '<li><a href="view.cat.php?page='.($page + 5).'">'.($page + 5).'</a></li>';
            if ($page + 4 <= $total) $page4right = '<li><a href="view.cat.php?page='.($page + 4).'">'.($page + 4).'</a></li>';
            if ($page + 3 <= $total) $page3right = '<li><a href="view.cat.php?page='.($page + 3).'">'.($page + 3).'</a></li>';
            if ($page + 2 <= $total) $page2right = '<li><a href="view.cat.php?page='.($page + 2).'">'.($page + 2).'</a></li>';
            if ($page + 1 <= $total) $page1right = '<li><a href="view.cat.php?page='.($page + 1).'">'.($page + 1).'</a></li>';


            if ($page+5 < $total)
            {
                //$strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_cat.php?$'.$catlink.'&type='.$type.'&sort='.$_GET["sort"].'&page='.$total.'">'.$total.'</a></li>';
                $strtotal = '<li><p class="nav-point">...</p></li><li><a href="view.cat.php?page='.$total.'">'.$total.'</a></li>';
            }else
            {
                $strtotal = "";
            }
            if ($total > 1)
            {
                echo '<div class="pstrnav"><ul>';
                 /*echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='''view_cat.php?'.$catlink.'cat='.$cat.'&type='.$type.'page=".$page."'''>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;*/ //es iyo ratom ar vici
                echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='view_cat.php?'.$catlink.'cat='.$cat.'&type='.$type.'page=".$page.">".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
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