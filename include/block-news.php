<div id="block-news">

<div><img  id="news-prev" src="images/img-prev.png" alt=""></div>
<div id="newsticker">
<ul>
    <?php
    $result = mysqli_query($link,"SELECT * FROM news ORDER BY id DESC");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        do
        {
         echo '<li>
    <span>'.$row["date"].'</span>
    <a href="#">'.$row["title"].'</a>
    <p>'.$row["text"].'</p>

</li>';
        }
    while ($row = mysqli_fetch_array($result));
    }
    ?>



</ul>

</div>
    <div><img  id="news-next" src="images/img-next.png" alt=""></div>

</div>