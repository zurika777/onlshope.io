<?php
defined('kasius') or die('mzgavsi gverdi ar moidzebna!');
?>
<div id="block__header">
    <div id="header-top-block">
        <div id="header-left-block">
            <nav id="nav-menu">
                <!--<a class="nav-left" href="index.php">მთავარი</a>-->
                <img src="uploads_images/phone-contact.svg" width="24px" alt="">
                <a class="nav-left"  href="index.php"> +995(32) 2204050</a>
                <!--
                <a class="nav-left" href="feedback.php">კონტაქტი</a>
                <a class="nav-left" href="include/main.php">ლინკი</a>
                <a class="nav-left" href="registration.php">ლინკი</a>-->
                <a class="nav-left" href="dmin/login.php" target="_blank">ადმინ</a>
            </nav>
            </div>    <!--/.header-left-block-->
        <div id="header-right-block">
            <nav id="nav-menu">
                <div class="block-shesvla-1">
                    <?php
                    if ($_SESSION['auth'] == true )
                    {
                        echo '<p id="auth-user-info"><img src="images/user.png" alt="img">მოგესალმებით, '.$_SESSION['auth_name'].'!</p>';
                    }else{
                        echo ' <a id="reg-auth-title"  class="nav-left nav-left-right" href="#">შეესვლა</a>
                <a id="reg-auth-title"  class="nav-left nav-left-right" href="registration.php">რეგისტრაცია</a>';
                    }
                    ?>
            <div id="block-top-auth">
                <div class="corner"></div>
                <form action="" method="post">
                    <ul id="input-email-pass">
                    <h3 class="shesvla-h3">შეავსეთ ველი</h3>
                    <p id="message-auth">მეილი ან პაროლი არასწორია </p>
                   <li><input type="text" id="auth_login" placeholder="სახელი ან იმეილი"></li>
                   <li><input type="password" id="auth_pass" placeholder="პაროლი"><span id="button-pass-show-hide" class="pass-show"></span></li>
<ul id="list-auth">
    <li><input type="checkbox" name="rememberme" id="rememberme"><label id="rememberme for="rememberme">დამახსოვრება</label></li>
    <li><a href="#" id="remind-pass">დაგავიწყდათ პაროლი?</a></li>
</ul>
                        <p><a id="button-auth" href="#">შესვლა</a></p>
                        <p class="auth-loading"><img class="img-auth" src="images/load.svg" alt=""></p>
                    </ul>
                </form>
                <div id="block-remind">
                    <h3>პაროლის აღდგენა</h3>
                    <p id="message-remind" class="message-remind-success"></p>
                    <input type="text" placeholder="E-mail" id="remind-email"/>
                    <p align="right" id="button-remind"><a>აღდგენა</a></p>
                    <p align="right" class="auth-loading"><img src="images/loading.gif" /></p>
                    <p id="prev-auth">უკან</p>
                </div>
            </div>
                </div>
            </nav>
        </div>   <!--/.header-right-block-->
</div>   <!--/.header-top-block-->
    <div id="conteineris" >
    <div id="block-user"> <!-- profilis-->
        <div class="corner2"></div>
        <ul>
            <li><img src="images/user_info.png" alt=""><a href="profile.php">პროფილი</a></li>
            <li><img src="images/logout.png" alt=""><a  id="logout">გამოსვლა</a></li>
        </ul>
    </div> <!-- /.profilis-->
   </div>
    <div id="intro-inner">  <!--intro-inner-->
        <div id="intro-content">  <!--intro-content-->
           <!-- <img src="uploads_images/logo.jpg" width="34px" height="34" alt="logo">-->
           <h2 id="intro-subtatle">ონლაინ მაღაზია</h2>
            <h1 id="intro-title">599002299</h1>
            <div id="intro-text">სამუშაო დღეები</div>
            <div id="social">
                <a href="#" class="social-link">
                    <img src="images/be.png" alt="social">
                </a>
                <a href="#" class="social-link">
                    <img src="images/dribl.png" alt="social">
                </a>
                <a href="#" class="social-link">
                    <img src="images/fb.png" alt="social">
                </a>
                <a href="#" class="social-link">
                    <img src="images/inst.png" alt="social">
                </a>
                <a href="#" class="social-link">
                    <img src="images/tvit.png" alt="social">
                </a>
                <a href="#" class="social-link">
                    <img src="images/in.png" alt="social">
                </a>
            </div>
            <button type="button" class="btn"  href="feedback.php" target="_parent" >დაგვიკავშირდით</button>
            <a class="btn" href="registration.php">კონსტრუქცია</a>
        </div>  <!--/.intro-content-->
        <div id="intro-photo"> <!-- intro-photo-->
            <img id="img-logo" src="images/phone.png" alt="img" >
            <!--<form class="form-inline">
                <input class="form-control " type="text" placeholder="Search">
                <button class="btn" type="submit">Search</button>
            </form>-->
        </div>  <!-- /.intro-photo-->
    </div>   <!--/.intro-inner-->
</div>   <!--/.block__header-->
<div id="works"><!-- kalatis meniu-->
<div id="works__nav">
    <li><img src="images/ui.png" alt=""><a class="works__nav-link" href="index.php">მთავარი</a></li>
    <li><img src="images/new-32.png" alt=""><a class="works__nav-link" href="view_aystopper.php?go=news">ახალი</a></li>
    <li><img src="images/bestprice-32.png" alt=""><a class="works__nav-link" href="view_aystopper.php?go=leaders">ლიდერი</a></li>
    <li><img src="images/sale-32.png" alt=""><a class="works__nav-link" href="view_aystopper.php?go=sale">ლიკვიდაცია</a></li>
</div>
    <div id="works__nav-right">
    <li id="block-basket"><img src="uploads_images/basket_white.svg" alt="img"><a href="cart.php?action=oneclick" class="works__righ-right">კალათა ცარიელია</a></li>
    </div>
</div><!-- /.kalatis meniu-->