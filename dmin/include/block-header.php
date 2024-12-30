<?php
define('kasius', true);

$result1 = mysqli_query($link,"SELECT * FROM orders WHERE order_confirmed='no'");
$count1 = mysqli_num_rows($result1);

if ($count1 > 0 ) { $count_str1 = '<p>+'.$count1.'</p>';} else { $count_str1 = ''; }

$result2 = mysqli_query($link,"SELECT * FROM table_reviews  WHERE moderat='0'");
$count2 = mysqli_num_rows($result2);
if ($count2 > 0 ) { $count_str2 = '<p>+'.$count2.'</p>';} else { $count_str2 = '';}

?>
<div id="block-header">
    <div id="block-header1">
        <h3>SHOP. სამართავი პანელი</h3>
        <p id="link-nav"><?php echo $_SESSION['urlpage']; ?></p>
    </div>
    <div id="block-header2">
        <p align="right"><a href="administrators.php" >ადმინისტრატორები</a> | <a href="?logout">გამოსვლა</a></p>
        <p align="right">შენ <span><?php echo $_SESSION['admin_role']; ?></span></p>
    </div>
</div>

<div id="left-nav">
    <ul>
        <li><a href="orders.php">შეკვეთები</a><?php echo $count_str1; ?></li>
        <li><a href="tovar.php">ნივთები</a></li>
        <li><a href="reviews.php">კომენტარები</a><?php echo $count_str2; ?></li>
        <li><a href="category.php">კატეგორიები</a></li>
        <li><a href="clients.php">მომხმარებლები</a></li>
        <li><a href="news.php">სიახლეები</a></li>
    </ul>
</div>
