<div id="block-news">

<div><img  id="news-prev" src="images/img-prev.png" alt=""></div>
<div id="newsticker">
<ul>
    <?php
    $result = mysqli_query($link,"SELECT * FROM news ORDER BY id DESC");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        do
        {
         echo '<li>
    <span>'.$row["date"].'</span>
    <a href="view_news.php?id='.$row["id"].'">'.mb_substr(stripslashes($row["title"]), 0, 20).'</a>
    <p>'.$row["text"].'</p>
    

</li>';
        }
    while ($row = mysqli_fetch_assoc($result));
    }
    ?>



</ul>

</div>
    <div><img  id="news-next" src="images/img-next.png" alt=""></div>

</div>