<?php
define('kasius',true);
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include("include/auth_cookie.php");
//unset($_SESSION['auth']); //sesiis gatishva
//setcookie('rememberme','',0, '/'); //cookis gacmenda
$id = clear_string($_GET["id"]);

/*seo*/
$seoquery = mysqli_query($link,"SELECT seo_words, seo_description FROM table_products WHERE products_id='$id' AND visible='1'");
if (mysqli_num_rows($seoquery) > 0)
{
    $seoquery = mysqli_fetch_array($seoquery);
}
/*/.seo*/
if ($id != $_SESSION['countid'])
{
    $querycount = mysqli_query($link,"SELECT count FROM table_products WHERE products_id='$id'");
    $resultcount = mysqli_fetch_array($querycount);
    $newcount = $resultcount["count"] + 1;
    $update = mysqli_query($link,"UPDATE table_products SET count='$newcount' WHERE products_id='$id'");

}
$_SESSION['countid'] = $id;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="<? echo $seoquery["seo_description"]; ?>">
    <meta name="keywords" content="<? echo $seoquery["seo_words"]; ?>">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link href="TrackBar/jQuery/trackbar.css" rel="stylesheet" type="text/css" />
    <link href="fancyBox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,300i,400,700&display=swap" rel="stylesheet">
    <!--[if lte IE 9]> <link rel="stylesheet" href="css/stylesie9.css"><![endif]-->
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/jcarouserllite_1.0.1.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jTabs.js"></script>
    <script type="text/javascript" src="fancyBox/source/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/jquery.TextChange.js"></script>
    <script type="text/javascript" src="TrackBar/jQuery/jquery.trackbar.js"></script>

    <title>psop</title>
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul.tabs").jTabs({content: ".tabs_content", animate: true, effect:"fade"});
            $(".image-modal").fancybox();
            $(".send-review").fancybox();
        });
    </script>
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
        $result1 = mysqli_query($link,"SELECT * FROM  table_products WHERE products_id='$id' AND visible='1'") ;
        if (mysqli_num_rows($result1) > 0)
        {
            $row1 = mysqli_fetch_array($result1);
            do
            {
                if (strlen($row1["images"]) > 0 && file_exists("uploads_images/".$row1["images"]))
                {
                    $img_path = 'uploads_images/' .$row1["images"];
                    $max_width = 300;
                    $max_height = 300;
                    list($width, $height) = getimagesize($img_path);
                    $ratioh = $max_height/$height;
                    $ratiow = $max_width/$width;
                    $ratio  = min($ratioh, $ratiow);
                    $width  = intval($ratio*$width);
                    $height = intval($ratio*$height);
                }else {
                    $img_path = "images/no-image.png";
                    $width = 110;
                    $height = 200;
                }
                //raodenoba komentaris
                $query_reviews = mysqli_query($link,"SELECT * FROM table_reviews WHERE products_id='$id' AND moderat='1'");
                $count_reviews = mysqli_num_rows($query_reviews);
                echo '
                <div id="block-breadcrumbs-and-rating">
                <p id="nav-breadcrumbs"><a href="view.cat.php?type=mobile">მობილური ტელეფონი</a> \ <span>'.$row1["brand"].'</span></p>
               <div id="block-like"> <!--like-->
               <p id="likegood" tid="'.$id.'">მოწონება</p><p id="likegoodcount">'.$row1["yes_like"].'</p>
                </div><!--/.like-->
               </div> 
               <div id="block-content-info">
               <img src="'.$img_path.'"  width="'.$width.'" height="'.$height.'" alt="img">
               <div id="block-mini-description">
               <p id="content-title">'.$row1["title"].'</p>
               <ul class="reviews-and-counts-content">
               <li><img src="images/eye-icon.png"  alt=""><p>'.$row1["count"].'</p></li>
               <li><img src="images/comment-icon.png"  alt=""><p>'.$count_reviews.'</p></li>
                </ul>
                <p id="style-price">'.group_numerals($row1["price"]).' ₾</p>
                <a class="add-cart" id="add-cart-view" tid="'.$row1["products_id"].'" href="#"></a>
               <p id="contect-text">'.$row1["mini_description"].'</p>
</div>
</div>
                ';


            }
            while ($row1 = mysqli_fetch_array($result1));
        $result = mysqli_query($link,"SELECT * FROM  uploads_images WHERE products_id='$id'") ;
        if (mysqli_num_rows($result) > 0)
        {
        $row = mysqli_fetch_array($result);
        echo '<div id="block-img-slide">
<ul>';
        do
        {
                $img_path = 'uploads_images/' .$row["image"];
                $max_width = 70;
                $max_height = 70;
                list($width, $height) = getimagesize($img_path);
                $ratioh = $max_height/$height;
                $ratiow = $max_width/$width;
                $ratio  = min($ratioh, $ratiow);
                $width  = intval($ratio*$width);
                $height = intval($ratio*$height);
                echo '<li><a class="image-modal" href="#image'.$row["id"].'" rel="group"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" alt="img"></a></li>
                <a href="#" style="display:none;" class="image-modal"  id="image'.$row["id"].'"><img src="uploads_images/'.$row["image"].'" alt="img"></a>
       ';
                
            }
        while ($row = mysqli_fetch_array($result));
            echo '</ul></div>';
        }
        $result = mysqli_query($link, "SELECT * FROM table_products WHERE products_id='$id' AND visible='1'");
        $row = mysqli_fetch_array($result);
            echo '
 <ul class="tabs">  
        <li ><a class="active" href="#">აღწერა</a></li>
        <li><a href="#">მონაცემები</a></li>
        <li><a href="#">კომენტარი</a></li>
    </ul>  
    <div class="clear"></div>
    <div class="tabs_content">
        <div>'.$row["description"].'</div>
        <div>'.$row["features"].'</div>
        <div><p id="link-send-review"><a class="send-review" href="#send-review">დატოვე კომენტარი</a></p>
           ';
            $query_reviews = mysqli_query($link,"SELECT * FROM table_reviews WHERE products_id='$id' AND moderat='1' ORDER BY reviews_id DESC");

            if (mysqli_num_rows($query_reviews) > 0)
            {
                $row_reviews = mysqli_fetch_array($query_reviews);
                do
                {
echo '<div class="block-reviews">
        <p class="author-date">'.$row_reviews["name"].', '.$row_reviews["date"].'</p>
        <img src="images/plus-reviews.png" alt="plus">
        <p class="textrev">'.$row_reviews["good_reviews"].'</p>
        <img src="images/minus-reviews.png" alt="minus">
        <p class="textrev">'.$row_reviews["bad_reviews"].'</p>
        <p class="text-comment">'.$row_reviews["comment"].'</p>
    </div>';
                }
                while ($row_reviews = mysqli_fetch_array($query_reviews));
            }
            else
            {
                echo '<p class="title-no-info">კომენტარი არ არის</p>';
            }

            echo'
        </div>
    </div><!-- tabs content -->
    
    <div id="send-review">
    <p id="title-review">გამოქვეყნდება მოდერაციის გავლის შემდგომ</p>
    <ul>    
    <li><p><label id="label-name">სახელი<span>*</span></label><input maxlength="15" type="text" id="name_review"></p></li>
    <li><p><label id="label-good">პლიუსი<span>*</span></label><textarea id="good_review"></textarea></p></li>
    <li><p><label id="label-bad">მინუსი<span>*</span></label><textarea id="bad_review"></textarea></p></li>
    <li><p><label id="label-comment">კომენტარი<span>*</span></label><textarea id="comment_review"></textarea></p></li>
    
    </ul>
    <p id="reload-img"><img src="images/loading.gif" alt=""></p><p id="button-send-review" iid="'.$id.'" ></p>
</div>
';
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