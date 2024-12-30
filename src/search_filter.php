<?php
define('kasius',true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");

$cat = clear_string($_GET["cat"]);
$type = clear_string($_GET["type"]);
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

    <title>გაფარტოებული ძიება</title>
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
        if ($_GET["brand"])
        {
            $check_brand = implode(',',$_GET["brand"]);
        }
        $start_price = (int)$_GET["start_price"];
        $end_price = (int)$_GET["end_price"];
        if (!empty($check_brand) OR !empty($end_price))
        {
            if (!empty($check_brand)) $query_brand = "AND brand_id IN($check_brand)";
            if (!empty($end_price)) $query_price = "AND price BETWEEN $start_price AND $end_price";
        }
        $result = mysqli_query($link,"SELECT * FROM  table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC") ;
        if (mysqli_num_rows($result) > 0)
        {
        $row = mysqli_fetch_array($result);

        echo '
        <div class="block-sorting"><!--block__sorting-->
            <p class="nav-breadcrumbs"><a class="nav-breadcrumbs-link" href="index.php">მთავარი</a> \ <span class="nav-breadcrumbs-link">ყველა ნივთი</span></p>
            <div class="options-list">
                <div><img id="style-grid" src="images/icon-grid.svg" width="24" height="24" alt="img"></div>
                <div><img id="style-list"  src="images/icon-list.svg" width="24" height="24" alt="img"></div>
             
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
<p id="style__title-grid"><a href="view_content.php?id='.$row["products_id"].'">'.mb_substr(stripslashes($row["title"]), 0, 22).'</a></p>
<ul id="reviews__and-count-grid">
<li><img src="images/eye.svg"  width="20" alt="eye"><p>'.$row["count"].'</p></li>
<li><img src="images/comment.svg"  width="18" alt="commnet"><p>'.$count_reviews.'</p></li>
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
            $result = mysqli_query($link,"SELECT * FROM  table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC") ;
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
  <div class="block__images-list"><a href="view_content.php?id='.$row["products_id"].'">
  <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a>
</div>

<ul id="reviews__and-counts-list">
<li><img src="images/eye.svg"  width="20" alt="eye"><p>'.$row["count"].'</p></li>
<li><img src="images/comment.svg"  width="18" alt="commnet"><p>'.$count_reviews.'</p></li>
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