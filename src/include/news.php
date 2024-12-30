<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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
    <a href="#">'.mb_substr(stripslashes($row["title"]), 0, 30).'</a>
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
</body>
</html>