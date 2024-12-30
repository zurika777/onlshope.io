<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth") {
    define('kasius', true);

    if (isset($_GET["logout"])) {
        unset($_SESSION['auth_admin']);
        header("location: login.php");
    }
    $_SESSION['urlpage'] = "<a href ='index.php'>მთავარი</a>";
    include("include/db_connect.php");
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <title>სამართავი პანელი</title>
    </head>
    <body>
    <div id="block-body">

        <?php
        include("include/block-header.php");
        $query1 = mysqli_query($link,"SELECT * FROM orders");
        $result1 = mysqli_num_rows($query1);

        $query2 = mysqli_query($link,"SELECT * FROM table_products");
        $result2 = mysqli_num_rows($query2);

        $query3 = mysqli_query($link,"SELECT * FROM table_reviews");
        $result3 = mysqli_num_rows($query3);

        $query4 = mysqli_query($link,"SELECT * FROM reg_user");
        $result4 = mysqli_num_rows($query4);

        $query5 = mysqli_query($link,"SELECT * FROM reg_admin");
        $result5 = mysqli_num_rows($query5);
        ?>
        <div id="block-content">
            <div id="block-parameters">
                <p id="title-page">საერთო სტატისტიკა</p>
            </div>
            <ul id="general-statistics">
                <li><p>სულ შეკვეთა - <span><?php echo $result1; ?></span></p></li>
                <li><p>ნივთები - <span><?php echo $result2; ?></span></p></li>
                <li><p>კომენტარები - <span><?php echo $result3; ?></span></p></li>
                <li><p>მომხმარებლები - <span><?php echo $result4; ?></span></p></li>
                <li><p>ადმინები - <span><?php echo $result5; ?></span></p></li>

            </ul>
            <h3 id="title-statistics"> გაყიდვების სტატისტიკა</h3>
            <TABLE align="center" CELLPADDING="10" WIDTH="100%">
                <TR>
                    <TH>თარიღი</TH>
                    <TH>ნივთი</TH>
                    <TH>ფასი</TH>
                    <TH>სტატუსი</TH>
                </TR>
                <?php
                $result = mysqli_query($link,"SELECT * FROM orders,buy_products WHERE orders.order_pay='accepted' AND orders.order_id=buy_products.buy_id_order");
                if (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    do
                    {
                        $result2 = mysqli_query($link,"SELECT * FROM table_products WHERE products_id='{$row["buy_id_product"]}'");
                        if (mysqli_num_rows($result2) > 0)
                        {
                            $row2 = mysqli_fetch_assoc($result2);
                        }
                        $statuspay = "";
                        if ($row["order_pay"] == "accepted") $statuspay = "გადახდილია";
                        echo '
                        <TR>
                    <TD align="CENTER">'.$row["order_datetime"].'</TD>
                    <TD align="CENTER">'.$row2["title"].'</TD>
                    <TD align="CENTER">'.$row2["price"].'</TD>
                    <TD align="CENTER">'.$statuspay.'</TD>
                </TR>
                        
                        ';
                    }
                    while ($row = mysqli_fetch_assoc($result));
                }

                ?>
            </TABLE>
        </div>
    </div>
    </body>

    </html>
    <?php
}else {
    header("location: login.php");
}
    ?>