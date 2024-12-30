<?php
defined('kasius') or die('mzgavsi gverdi ar moidzebna!');
?>

<ul id="block__tovar-grid1">
    <?php


    $result = mysqli_query($link,"SELECT DISTINCT * FROM table_products WHERE visible='1' ORDER BY RAND() LIMIT 5") ;
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
            echo '
  <li>
  <div id="block__images-grid"><a href="view_content.php?id='.$row["products_id"].'">
  <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a></a>
</div>
<p id="style__title-grid"><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>


<p class="style__price-grid"><strong class="style__price-grid-strong">'.group_numerals($row["price"]).'</strong> ₾</p>
<div class="mini__features">'.$row["mini_features"].'</div>
<a class="add__cart-style-grid" href="#" tid="'.$row["products_id"].'"></a>

</li>';
        }
        while ($row = mysqli_fetch_array($result));
    }
    ?>
