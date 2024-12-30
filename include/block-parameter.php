<?php
defined('kasius') or header('Location: index.php');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#blocktrackbar').trackbar({
            onMove: function() {
                document.getElementById('start-price').value = this.leftValue;
                document.getElementById('end-price').value = this.rightValue;
            },
            width: 160,
            leftLimit: 1,
            leftValue: <?php
                if ((int)$_GET["stat_price"] >=1 AND (int)$_GET["start_price"] <=50000)
                {
                    echo (int)$_GET["start_price"];
                }else
                {
                    echo "1";
                }
            ?>,
            rightLimit: 50000,
            rightValue: <?php
            if ((int)$_GET["end_price"] >=1 AND (int)$_GET["end_price"] <=50000)
            {
                echo (int)$_GET["end_price"];
            }else
            {
                echo "30000";
            }
            ?>,
             roundUp: 1
        });
    });
</script>
<div id="lock-parameter">
    <p class="header-right-title">ძიება პარამეტრით</p>

<p class="title-filter">ღირებულება</p>

    <form method="GET" action="search_filter.php">
<div id="block-input-price">
<ul>
    <li><p>ot</p></li>
    <li><input type="text" id="start-price" name="start_price" value="1000"></li>
    <li><p>do</p></li>
    <li><input type="text" id="end-price" name="end_price" value="30000"></li>
    <li><p>ლარი</p></li>
</ul>
</div>

        <div id="blocktrackbar"></div>
        <p class="title-filter">მწარმოებელი</p>

<ul class="checkbox-brand">
    <?php
    $result = mysqli_query($link,"SELECT * FROM category WHERE type='mobile'");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        do
        {
            $checked_brand= "";
            if ($_GET["brand"])
            {
                if (in_array($row["id"],$_GET["brand"]))
                {
                    $checked_brand = "checked";
                }
            }
echo '
 <li><input '.$checked_brand.' type="checkbox" name="brand[]" value="'.$row["id"].'" id="checkbrend'.$row["id"].'"><label for="checkbrend'.$row["id"].'">'.$row["brand"].'</label></li>
';
        }
        while ($row = mysqli_fetch_array($result));
    }
    ?>


</ul>
        <input type="submit" name="submit" id="button-param-search" value="" >
    </form>

</div>