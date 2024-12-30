<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);

    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='orders.php'> შეკვეთები</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    $id =clear_string($_GET["id"]);
    $sort =$_GET["sort"];

       switch ($sort)
       {
    case 'all-orders';
    $sort = "order_id DESC";
    $sort_name = 'ა დან ბ მდე';
    break;
    case 'confirmed':
    $sort = "order_confirmed = 'yes' DESC";
    $sort_name = 'დამუშავებული';
    break;
     case 'no-confirmed':
    $sort = "order_confirmed = 'no' DESC";
    $sort_name = 'დაუმუშავებელი';
    break;
           default:
               $sort = "order_id  DESC";
               $sort_name = 'ა დან ბ მდე';
               break;

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
        <title>შეკვეთები</title>
    </head>
    <body>
    <div id="block-body">

        <?php
        include("include/block-header.php");
        $all_count = mysqli_query($link,"SELECT * FROM orders");
        $all_count_result = mysqli_num_rows($all_count);
        $buy_count = mysqli_query($link,"SELECT * FROM orders WHERE order_confirmed = 'yes'");
        $buy_count_result = mysqli_num_rows($buy_count);
        $no_buy_count = mysqli_query($link,"SELECT * FROM orders WHERE order_confirmed = 'no'");
        $no_buy_count_result = mysqli_num_rows($no_buy_count);

        ?>
        <div id="block-content">
            <div id="block-parameters">
                <ul id="options-list">
                    <p id="title-page">შეკვეთები</p>
                    <li>სორტირება</li>
                    <li><a id="select-links" href="#"><? echo $sort_name; ?></a>
                        <ul id="list-links-sort">
                            <li><a href="orders.php?sort=all-orders">ა დან ბ მდე</a></li>
                            <li><a href="orders.php?sort=confirmed">დამუშავებული</a></li>
                            <li><a href="orders.php?sort=no-confirmed">დაუმუშავებელი</a></li>

                        </ul>
                    </li>
                </ul>
            </div>
            <div id="block-info">
                <ul id="review-info-count">
                    <li>სულ შეკვეთა - <strong><?php echo $all_count_result; ?></strong></li>
                    <li>დამუშავებული - <strong><?php echo $buy_count_result; ?></strong></li>
                    <li>დაუმუშავებელი შეკვეთა - <strong><?php echo $no_buy_count_result; ?></strong></li>

                </ul>
            </div>
            <?php
    $num = 10;
    $page = strip_tags($_GET['page']);
    //$page = $link ->real_escape_string($page);
    //$page = mysqli_real_escape_string($page);
    $page = mysqli_real_escape_string($link, $page);

    $count = mysqli_query($link, "SELECT COUNT(*) FROM orders");
    $temp = mysqli_fetch_array($count);
    $post = $temp[0];
    $total = (($post - 1) / $num) + 1;
    $total = intval($total);
    $page = intval($page);

    if (empty($page) or $page < 0) $page = 1;
    if ($page > $total) $page = $total;

    $start = $page * $num - $num;
    if ($temp[0] > 0) {
        $result = mysqli_query($link, "SELECT * FROM orders ORDER BY $sort LIMIT $start, $num ");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            do {
                if ($row["order_confirmed"] == 'yes') {
                    $status = '<span class="green">დამუშავებულია</span>';
                } else {
                    $status = '<span class="red">დაუმუშავებელია</span>';
                }
                echo '
                    <div class="block-order">
                     <p class="order-datetime">' . $row["order_datetime"] . '</p>
                    <p class="order-number">შეკვეთა # ' . $row["order_id"] . ' - ' . $status . '</p>
                    <p class="order-link"><a class="green" href="view_order.php?id=' . $row["order_id"] . '">დაწვრილებით</a></p>
                    
                    
                    </div>
                    
                    ';
            } while ($row = mysqli_fetch_assoc($result));
        }
    }    if ($page != 1) {
                $pervpage = '<li><a class="pstr-prev" href="orders.php?page=' . ($page - 1) . '">&lt;</a></li>';
            }
            if ($page != $total) $nextpage = '<li><a class="pstr-next" href="orders.php?page=' . ($page + 1) . '">&gt;</a></li>';


            if ($page - 5 > 0) $page5left = '<li><a href="orders.php?page=' . ($page - 5) . '">' . ($page - 5) . '</a></li>';
            if ($page - 4 > 0) $page4left = '<li><a href="orders.php?page=' . ($page - 4) . '">' . ($page - 4) . '</a></li>';
            if ($page - 3 > 0) $page3left = '<li><a href="orders.php?page=' . ($page - 3) . '">' . ($page - 3) . '</a></li>';
            if ($page - 2 > 0) $page2left = '<li><a href="orders.php?page=' . ($page - 2) . '">' . ($page - 2) . '</a></li>';
            if ($page - 1 > 0) $page1left = '<li><a href="orders.php?page=' . ($page - 1) . '">' . ($page - 1) . '</a></li>';


            if ($page + 5 <= $total) $page5right = '<li><a href="orders.php?page=' . ($page + 5) . '">' . ($page + 5) . '</a></li>';
            if ($page + 4 <= $total) $page4right = '<li><a href="orders.php?page=' . ($page + 4) . '">' . ($page + 4) . '</a></li>';
            if ($page + 3 <= $total) $page3right = '<li><a href="orders.php?page=' . ($page + 3) . '">' . ($page + 3) . '</a></li>';
            if ($page + 2 <= $total) $page2right = '<li><a href="orders.php?page=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
            if ($page + 1 <= $total) $page1right = '<li><a href="orders.php?page=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';

            if ($page + 5 < $total) {
                //$strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_cat.php?$'.$catlink.'&type='.$type.'&sort='.$_GET["sort"].'&page='.$total.'">'.$total.'</a></li>';
                $strtotal = '<li><p class="nav-point">...</p></li><li><a href="orders.php?page=' . $total . '">' . $total . '</a></li>';
            } else {
                $strtotal = "";
            }
            if ($total > 1) {
                echo '<div class="pstrnav"><ul>';

                /*echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='''view_cat.php?'.$catlink.'cat='.$cat.'&type='.$type.'page=".$page."'''>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;*/ //es iyo ratom ar vici
                echo $pervpage . $page5left . $page4left . $page3left . $page2left . $page1left . "<li><a class='pstr-active' href='clients.php?page=" . $page . "'>" . $page . "</a></li>" . $page1right . $page2right . $page3right . $page4right . $page5right . $strtotal . $nextpage;
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