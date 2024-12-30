<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);
    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='clients.php'> მომხმარებლები</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    $id = clear_string($_GET["id"]);
    $action = $_GET["action"];
    if (isset($action))
    {
        switch ($action) {

            case 'delete':
                if ($_SESSION['delete_clients'] == '1'){



                    $delete = mysqli_query($link,"DELETE FROM reg_user WHERE id='$id'");
                }else
                {
                    $msgerror = 'თქვენ არ გაქვთ მომხმარებლების წაშლის ნებართვა!';
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
        $all_client = mysqli_query($link,"SELECT * FROM reg_user");
        $result_count = mysqli_num_rows($all_client);
        ?>
        <div id="block-content">
            <div id="block-parameters">
                <p id="count-client">მომხმარებლები - <strong><?php echo $result_count; ?></strong></p>
            </div>
            <?php
            if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
            if ($_SESSION['view_clients'] == '1') {
                $num = 4;
                $page = strip_tags($_GET['page']);
                //$page = $link ->real_escape_string($page);
                //$page = mysqli_real_escape_string($page);
                $page = mysqli_real_escape_string($link, $page);

                $count = mysqli_query($link, "SELECT COUNT(*) FROM reg_user");
                $temp = mysqli_fetch_array($count);
                $post = $temp[0];
                $total = (($post - 1) / $num) + 1;
                $total = intval($total);
                $page = intval($page);

                if (empty($page) or $page < 0) $page = 1;
                if ($page > $total) $page = $total;

                $start = $page * $num - $num;
                if ($temp[0] > 0) {
                    $result = mysqli_query($link, "SELECT * FROM reg_user ORDER BY id DESC LIMIT $start, $num");
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_array($result);
                        do {
                            echo '<div class="block-clients">
                 
                     <p class="client-datetime"><strong>' . $row["datetime"] . '</p>
                     <p class="client-email"><strong>' . $row["email"] . '</strong></p>
                     <p class="client-links"><a class="delete" rel="clients.php?id=' . $row["id"] . '&action=delete" >წაშლა</a></p>
          
                  <ul>
                    <li><strong>E-mail</strong> - ' . $row["email"] . '</li>
                    <li><strong>ფიო</strong> - ' . $row["surname"] . ' ' . $row["name"] . ' ' . $row["patronymic"] . '</li>
                    <li><strong>მისამართი</strong> - ' . $row["address"] . '</li>
                    <li><strong>ტელეფონი</strong> - ' . $row["phone"] . '</li>
                    <li><strong>IP</strong> - ' . $row["ip"] . '</li>
                    <li><strong>რეგისტრაციის თარიღი</strong> - ' . $row["datetime"] . '</li>
                    </ul>
            </div>';
                        } while ($row = mysqli_fetch_array($result));
                    }
                }
                if ($page != 1) {
                    $pervpage = '<li><a class="pstr-prev" href="clients.php?page=' . ($page - 1) . '">&lt;</a></li>';
                }
                if ($page != $total) $nextpage = '<li><a class="pstr-next" href="clients.php?page=' . ($page + 1) . '">&gt;</a></li>';


                if ($page - 5 > 0) $page5left = '<li><a href="clients.php?page=' . ($page - 5) . '">' . ($page - 5) . '</a></li>';
                if ($page - 4 > 0) $page4left = '<li><a href="clients.php?page=' . ($page - 4) . '">' . ($page - 4) . '</a></li>';
                if ($page - 3 > 0) $page3left = '<li><a href="clients.php?page=' . ($page - 3) . '">' . ($page - 3) . '</a></li>';
                if ($page - 2 > 0) $page2left = '<li><a href="clients.php?page=' . ($page - 2) . '">' . ($page - 2) . '</a></li>';
                if ($page - 1 > 0) $page1left = '<li><a href="clients.php?page=' . ($page - 1) . '">' . ($page - 1) . '</a></li>';


                if ($page + 5 <= $total) $page5right = '<li><a href="clients.php?page=' . ($page + 5) . '">' . ($page + 5) . '</a></li>';
                if ($page + 4 <= $total) $page4right = '<li><a href="clients.php?page=' . ($page + 4) . '">' . ($page + 4) . '</a></li>';
                if ($page + 3 <= $total) $page3right = '<li><a href="clients.php?page=' . ($page + 3) . '">' . ($page + 3) . '</a></li>';
                if ($page + 2 <= $total) $page2right = '<li><a href="clients.php?page=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
                if ($page + 1 <= $total) $page1right = '<li><a href="clients.php?page=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';

                if ($page + 5 < $total) {
                    //$strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_cat.php?$'.$catlink.'&type='.$type.'&sort='.$_GET["sort"].'&page='.$total.'">'.$total.'</a></li>';
                    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="clients.php?page=' . $total . '">' . $total . '</a></li>';
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
            }else{
                echo '<p id="form-error" align="center"> თქვენ არ გაქვთ ამ გვერდის ნახვის ნებართვა!</p>';
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