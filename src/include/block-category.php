<?php
defined('kasius') or die('mzgavsi gverdi ar moidzebna!');
?>
<div id="block-category">
    <div id="block-search"> <!--serchi-->
        <form method="GET" action="search.php?q=">
            <span><input type="submit" id="button-search" value=""></span>
            <input type="text" id="input-search" name="q" placeholder="ძიება" value="<?php echo "$search"; ?>">
          <!--  <a href="#" type="submit"><img  id="button-search" src="images/icon-search.png" alt="image"></a>-->
        </form>
        <ul id="result-search">

        </ul>

    </div>   <!--/.serchi-->

<p class="header-right-title">ნავიგაცია</p>
<ul>
    <li class="cat-top"><a id="index1" href="#"><img class="img-cat" src="images/mobilephone.svg" width="30px" alt="image" id="mobile-images"><strong class="category-mob">მობილური ტელეფონი</strong></a>

        <ul class="category-section">
    <li><a href="view.cat.php?type=mobile"><strong class="category-strong">ყველა მოდელი</strong></a></li>

<?php

$result = mysqli_query($link, "SELECT * FROM category  WHERE type='mobile'");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    do {
        echo '
        <li><a href="view.cat.php?cat='.strtolower($row["brand"]) .'&type='.$row["type"].'">'.$row["brand"].'</a></li>
        
        ';
    } while ($row = mysqli_fetch_array($result));

}


?>


</ul>
        </li>
    <li class="cat-top"><a id="index2" href="#"><img class="img-cat" src="images/nout.svg" width="30px" alt="image"><strong class="category-mob">ნოუთბუქი</strong></a>

        <ul class="category-section">
            <li><a href="view.cat.php?type=notebook"><strong class="category-strong">ყველა მოდელი</strong></a></li>

            <?php

            $result = mysqli_query($link, "SELECT * FROM category  WHERE type='notebook'");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {
                    echo '
        <li><a href="view.cat.php?cat='.strtolower($row["brand"]) .'&type='.$row["type"].'">'.$row["brand"].'</a></li>
        
        ';
                } while ($row = mysqli_fetch_array($result));

            }


            ?>

    </ul>
    </li>
    <li class="cat-top"><a id="index3" href="#"><img class="img-cat" src="images/tablet.svg" width="30px" alt="image"><strong class="category-mob">მობილური ტელეფონი</strong></a>


        <ul class="category-section">
            <li><a href="view.cat.php?type=notepad"><strong class="category-strong">ყველა მოდელი</strong></a></li>

            <?php

            $result = mysqli_query($link, "SELECT * FROM category  WHERE type='notepad'");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {
                    echo '
        <li ><a href="view.cat.php?cat='.strtolower($row["brand"]) .'&type='.$row["type"].'">'.$row["brand"].'</a></li>
        
        ';
                } while ($row = mysqli_fetch_array($result));

            }
            ?>
    </ul>
    </li>

    <li class="cat-top"><a id="index4" href="#"><img class="img-cat" src="images/tablet.svg" width="30px" alt="image"><strong class="category-mob">სკუტერები</strong></a>


        <ul class="category-section">
            <li><a href="view.cat.php?type=scooter"><strong class="category-strong">ყველა მოდელი</strong></a></li>

            <?php

            $result = mysqli_query($link, "SELECT * FROM category  WHERE type='scooter'");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {
                    echo '
        <li ><a href="view.cat.php?cat='.strtolower($row["brand"]) .'&type='.$row["type"].'">'.$row["brand"].'</a></li>
        
        ';
                } while ($row = mysqli_fetch_array($result));

            }
            ?>
        </ul>
    </li>
    </ul>
</div>