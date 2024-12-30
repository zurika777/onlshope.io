<?php
define('kasius', true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");
//unset($_SESSION['auth']); //sesiis gatishva
//setcookie('rememberme','',0, '/'); //cookis gacmenda
$sorting = $_GET["sort"];

switch ($sorting)
{
    case 'price-asc';
    $sorting = 'price ASC';
    $sort_name = 'იაფიანიდან ძვირამდე';
    break;

    case 'price-desc';
    $sorting = 'price DESC';
    $sort_name = 'ძვირიანიდან იაფამდე';
    break;

    case 'popular';
        $sorting = 'count DESC';
        $sort_name = 'პოპულარული';
        break;

    case 'news';
        $sorting = 'datetime DESC';
        $sort_name = 'ახლები';
        break;

    case 'brand';
        $sorting = 'brand ASC';
        $sort_name = 'ა დან ბ მდე';
        break;

    default:
       $sorting = 'products_id DESC';
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
<?php include("include/main.php"); ?>
<div id="block__body"> <!--igive konteineria container-->
    <?php include("include/block__header.php"); ?>   <!--block__header-->
    <div id="block__right">  <!--block__right-->
        <?php
        ?>   <!--block__header-->
    </div>    <!--/.block__right-->

    <div class="block__content1">   <!--block__content-->
        <div class="block-sorting"><!--block__sorting-->
            <div class="options-list">
                <div class="imgklock">
                <img  src="uploads_images/star.svg" width="17px" alt=""></div>
                <div class="listp"><p>მოთხოვნადი</p></div><div class="listline"></div>
            </div>
        </div> <!--/.block__sorting-->
        <?php
        include("include/block-randum2.php");
        ?>

    <div class="block-sorting"><!--block__sorting-->
        <div class="options-list">
            <div class="imgklock">
            <img  src="uploads_images/chronometer.svg" width="17px" alt=""></div>
            <div class="listp"><p>ცხელი შეთავაზებები</p></div><div class="listline"></div>

        <div id="sorting-list">
            <div><a class="select-sort" href="index.php?sort=price-asc">იაფიანიდან ძვირამდე</a></div>
            <div><a class="select-sort" href="index.php?sort=price-desc">ძვირიანიდან იაფამდე</a></div>
            <div><a class="select-sort" href="index.php?sort=popular">პოპულარული</a></div>
            <div><a class="select-sort" href="index.php?sort=news">ახლები</a></div>
            <div><a class="select-sort" href="index.php?sort=brand">ა დან ბ მდე</a></div>
        </div>
        </div>
    </div> <!--/.block__sorting-->

<ul id="block__tovar-grid1">
        <?php
        $num = 10;  // aq vutitebt ramdeni gvinda rom ganovitanot
        $page =  (int)$_GET['page'];

        $count = mysqli_query($link,"SELECT COUNT(*) FROM  table_products  WHERE visible='1'");
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

        $result = mysqli_query($link,"SELECT * FROM  table_products WHERE visible='1' ORDER BY $sorting $qury_start_num") ;
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
                //raodenoba komentaris
                $query_reviews = mysqli_query($link,"SELECT * FROM table_reviews WHERE products_id='{$row["products_id"]}' AND moderat='1'");
                $count_reviews = mysqli_num_rows($query_reviews);
                if ($row["sale"] == 1){
                    $sale = '<p class="articles__left"> ფასდაკლება</p>';

                }else {
                    $sale = '<p class="articles__left1"></p>';
                }

                if ($row["new"] == 1){
                    $new = '<p class="articles__right"> ახალი</p>';

                }else {
                    $new = '<p class="articles__right1"></p>';
                }
                echo '
    <li>
    <div id="block__images-grid"><a href="view_content.php?id='.$row["products_id"].'">
    <div class="aystopper">
    <div>'.$sale.'</div>
    <div>'.$new.'</div>
    </div>
    
    <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a>
    </div>
    <p id="style__title-grid"><a href="view_content.php?id='.$row["products_id"].'">'.mb_substr(stripslashes($row["title"]), 0, 22).'</a></p>


    <p class="style__price-grid"><strong class="style__price-grid-strong">'.group_numerals($row["price"]).'</strong> ₾</p>
    <div class="mini__features">'.$row["mini_features"].'</div>
    <a class="add__cart-style-grid" href="#" tid="'.$row["products_id"].'"></a>
    

    </li>';
        }
            while ($row = mysqli_fetch_array($result));
        }
        ?>
    </ul>
        <div class="block-sorting"><!--block__sorting-->
            <div class="options-list">
                <div class="imgklock">
                    <img  src="uploads_images/star.svg" width="17px" alt=""></div>
                <div class="listp"><p>პოპულარულები</p></div><div class="listline"></div>
            </div>
        </div> <!--/.block__sorting-->
        <?php
        include("include/block-randum2.php");
        ?>

        <div class="block-sorting"><!--block__sorting-->
    </div> <!--/.block__content-->
    <div> <!--/.footer-->

        <?php
        include("include/service.php");
        include("include/block__footer.php"); ?> <!--block__footer-->
    </div> <!--//footer-->
    </div>  <!--/.igive konteineria container-->

    <script src="js/app.js"></script>
    <script src="js/satestoa.js"></script>
</body>
</html>