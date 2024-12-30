<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);

    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php'>მთავარი</a> \ <a href='view_order.php'> შეკვეთების ნახვა</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    $id = clear_string($_GET["id"]);
    $action = $_GET["action"];
    if (isset($action)) {
        switch ($action) {
            case 'accept':
                if ($_SESSION['accept_orders'] == '1')
                {
                $update = mysqli_query($link, "UPDATE orders SET order_confirmed='yes' WHERE order_id='$id'");
                }else
                {
                    $msgerror = 'თქვენ არ გაქვთ ნებართვა ამ შეკვეთის დამტკიცების!';
                }
                break;
            case 'delete':
                if ($_SESSION['delete_orders'] == '1')
                {
                    $delete = mysqli_query($link, "DELETE FROM orders WHERE order_id = '$id'");
                    header("Location: orders.php");
                }else
                    {
                        $msgerror = 'თქვენ არ გაქვთ ნებართვა ამ შეკვეთის წაშლის!';
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
        <script type="text/javascript" src="js/fancyBox/source/jquery.fancybox.js"></script>
        <script type="text/javascript" src="jquery_confirm/script.js"></script>
        <title>სამართავი პანელი - შეკვეთების ნახვა</title>
        <title>შეკვეთები</title>
    </head>
    <body>
    <div id="block-body">

    <?php
    include("include/block-header.php");
    ?>
    <div id="block-content">
    <div id="block-parameters">
        <p id="title-page">შეკვეთების ნახვა</p>
    </div>
    <?php
    if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
    if ($_SESSION['view_orders'] == '1') {

        $result = mysqli_query($link, "SELECT * FROM orders WHERE order_id = '$id'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            do {
                if ($row{"order_confirmed"} == 'yes') {
                    $status = '<span class="green">დამუშავებული</span>';
                } else {
                    $status = '<span class="red">დაუმუშავებელი</span>';
                }
                echo '
                       <p class="oview-rder-link"><a class="green" href="view_order.php?id=' . $row["order_id"] . '&action=accept">შეკვეთის დამტკიცება</a> | <a class="delete" rel="view_order.php?id=' . $row["order_id"] . '&action=delete">წაშლა</a></p>
                     <p class="order-datetime">' . $row["order_datetime"] . '</p>
                    <p class="order-number">შეკვეთა # ' . $row["order_id"] . ' - ' . $status . '</p>
                    <TABLE align="center" CELLPADDING="10" WIDTH="100%">
                    <TR><TH>#</TH>
                    <TH>ნივთის დასახელება</TH>
                    <TH>ფასი</TH>
                    <TH>რაოდენობა</TH>
                    </TR>
                    ';
                $query_product = mysqli_query($link, "SELECT * FROM buy_products,table_products WHERE buy_products.buy_id_order = '$id' AND table_products.products_id = buy_products.buy_id_product");
                $result_query = mysqli_fetch_assoc($query_product);
                do {
                    $price = $price + $result_query["price"] * $result_query["buy_count_product"];
                    $index_count = $index_count + 1;
                    echo '
                        <TR>
                        <TD align="CENTER">' . $index_count . '</TD>
                        <TD align="CENTER">' . $result_query["title"] . '</TD>
                        <TD align="CENTER">' . $result_query["price"] . ' ლარი</TD>
                        <TD align="CENTER">' . $result_query["buy_count_product"] . '</TD>
                    </TR>
                        ';

                } while ($result_query = mysqli_fetch_assoc($query_product));
                if ($row{"order_pay"} == 'accepted') {
                    $statpay = '<span class="green">გადახდილია</span>';
                } else {
                    $statpay = '<span class="red">გადაუხდელია</span>';
                }
                echo '
            
            </TABLE>
            <ul id="info-order">
            <li>საერთო ფასი - <span>' . $price . '</span> ლარი</li>
            <li>მიწოდების მეთოდი - <span>' . $row["order_dostavka"] . '</span></li>
            <li>გადახდის სტატუსი - ' . $statpay . '</li>
            <li>გადახდის მეთოდი - <span>' . $row["order_type_pay"] . '</span></li>
            <li>გადახდის დრო - <span>' . $row["order_datetime"] . '</span></li>
            </ul>
            <TABLE align="center" CELLPADDING="10" WIDTH="100%" >
            <TR>
            <TH>ფიო</TH>
            <TH>მისამართი</TH>
            <TH>კონტაქტი</TH>
            <TH>კომენტარი</TH>
            </TR>
            <TR>
            <TD align="CENTER">' . $row["order_fio"] . '</TD>
            <TD align="CENTER">' . $row["order_address"] . '</TD>
            <TD align="CENTER">' . $row["order_phone"] . '</br>' . $row["order_email"] . '</TD>
            <TD align="CENTER">' . $row["order_note"] . '</TD>
</TR>
</TABLE>
            
            ';
            } while ($row = mysqli_fetch_assoc($result));
        }
    }else{
        echo '<p id="form-error" align="center"> თქვენ არ გაქვთ ნებართვა ამ განყოფილების ნახვის!</p> ';
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