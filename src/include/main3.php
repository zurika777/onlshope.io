<?php
define('kasius', true);
include("db_connect.php")
?>
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

<?php
$x = 1; //გლობალური
function mytest() {

    //echo $x; ar aris scori shigniT Cawera
}
mytest();
echo $x;

?>
<br >
==================================
<br >
<?php

function myTest1() {  //lokaluri tvaltaxedva

    $x = 2;
    echo $x; //ar aris scori shigniT Cawera
}
myTest1();

?>
<br >
======================================
<br >
<?php

function myTest2() {  //lokaluri tvaltaxedva

    $x = 3;
    echo $x; //ar aris scori shigniT Cawera
}
myTest2();

?>
<br >
======================================
<br >
<?php

function myTest3() {  //lokaluri tvaltaxedva

   echo  $x = 4;

}
function yourTest3() {  //lokaluri tvaltaxedva

    echo $x = 3;

}
myTest3();
yourTest3();

?>
<br >

======================================
<br >
<?php
$x = 5;
$y = 10;

function myTest5()
{
    global $x, $y;
    $y = $x + $y;
}

myTest5();
echo $y; // შედეგი 15
?>
<br >
======================================
<br >
<?php
$x = 5;
$y = 10;

function myTest6()
{
    $GLOBALS['y'] = $GLOBALS['x'] + $GLOBALS['y'];
}

myTest6();

echo $y; // outputs 15
?>
<br >

<br >
======================================
<br >
<?php
function mytest7() {
    static $x = 0;
    echo "$x <br>";
     $x++;
}
mytest7();
mytest7();
mytest7();
mytest7();
?>



<br >

<br >
======================================
<br >
<?php
echo "<h2>aba!</h2>";
echo "gamarjoba msofliov!<br>";

echo strlen("gamarjoba msofliov!") , "<br >"; // სტრიქონის სიგრძის გაგება . შედეგი იქნება 19
echo str_word_count("gamarjoba msofliqqov msofliqqov!"), " <br >"; // სტრიქონის sityvebisd გაგება . შედეგი იქნება 19

echo str_word_count("gamarjoba msofliqqov msofliqqov!"), "<br >"; // სტრიქონის sityvebisd გაგება . შედეგი იქნება 19

$x="gamarjoba";
?>


<?php
$result = mysqli_query($link,"SELECT * FROM  table_products ");
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_array($result);
do{
    echo '<p>'.$row["title"].'</p>';
}
while ($row = mysqli_fetch_array($result));
}

?>

<br >

<?php
$query1 = mysqli_query($link,"SELECT * FROM table_products WHERE products_id='$id' AND sale='1'");
$result1 = mysqli_num_rows($query1);
if ($result1["sale"] > 0 )  { //ar aris scori
    echo 'maragshi ar gvqvs!';
}else {
    echo 'image maragshia!';

}
print_r($result1["sale"]);
?>
<br>
<?php
/*
class Car
{
function Car()
 {

$this->model= "rezo";
 }
}
$car = new Car();

echo $car->model;

*/?>
<br>
<?php
$result14 = mysqli_query($link,"SELECt * FROM category");
if (mysqli_num_rows($result14) > 0){
    $row14 = mysqli_fetch_assoc($result14);
    do{

        echo '<p>'.$row14["type"].'</p>';
    }while ($row14 = mysqli_fetch_assoc($result14));

}



?>
<form  enctype="multipart/form-data" method="post">
    <ul id="checkbox">
        <li><input type="checkbox" name="chk_visible" id="chk_visible" /><label for="chk_visible">ჩვენება ნივთის</label></li>

    </ul>
</form>


<br>
<br><br><br>

<?php
$n = 0 ;
if ($n > 0 ) {
    echo 'piroba sheshmaritia';
}elseif ($n < 0){
    echo 'piroba mcdaria';
}else {
    echo '0 - tolia';
}
?>



<br>
<br><br><br>
<br>
<br><br><br>
<?php
$favcolor = "ლურჯი";

switch ($favcolor)
{
    case "ლურჯი":
        echo "თქვენი ფავორიტი ფერია ლურჯი";
        break;
    case "წითელი":
        echo "თქვენი ფავორიტი ფერია წითელი";
        break;
    case "მწვანე":
        echo "თქვენი ფავორიტი ფერია მწვანე";
        break;
    default:
        echo "თქვენი ფავორიტი ფერია ნარინჯისფერი";
}
?>



<br>
<br><br><br>
<br>
<br><br><br>
<?php
switch ($n)
{
    case "label1":
      echo  'კოდი შესრულდება თუ n=label1';
        break;
    case "label2":
        echo   'კოდი შესრულდება თუ n=label2';
        break;
    case "label3":
        echo  'კოდი შესრულდება თუ n=label3';
        break;
    default:
        echo 'კოდი შესრულდება თუ n != არც ერთ ზემოთა ვარიანტს';
}
?>

<form action="main2.php" method="post">
    java <input type="checkbox" value="java" name="check1">

    <input type="submit" value="submit">


</form>

<!--//es unda iyos im gverdze sadac unda gamovitanot-->
<?php
echo $_REQUEST['check1'];
?>
<br>
<br>
<br>
<hr>

<?php
($action = "აჩვენე_ვერსია");
if ($action == "აჩვენე_ვერსია") {
echo "versia 123";
}
var_dump((bool) ""); // bool(false)
var_dump((bool) 1); // bool(true)
var_dump((bool) -2); // bool(true)
var_dump((bool) "foo"); // bool(true)
var_dump((bool) 2.3e5); // bool(true)
var_dump((bool) array(12)); // bool(true)
var_dump((bool) array()); // bool(false)
var_dump((bool) "false");



?>
<br>
<br>
<hr>


<?php
$a = 1234; // ათობითი რიცხვი
$a = -123; // უარყოფითი რიცხვი
$c = 0123; // რვაობითი რიცხვი (ეს ეკვივალენტურია 83 ათობით

$d = 0x1A; // თექვსმეტობითი რიცხვი (ეს
//ეკვივალენტურია 26 ათობით სისტემაში)

echo $a;
echo $b;
echo $c;
echo $d;
echo "\"ss\" , a\$";
echo 'ცვლადის $expand ასევე $either მნიშვნელობა არ გამოდის ';
?>


<hr>
<?php
$name1= "chemi saxelia";
$name2 = $name1 . " zuriko ";

echo "$name2"; // გამოიტანს "ჩემი სახელია ნიკოლოზი!"
echo "<br>";
$name3 = $name2 ." მე 15 წლის ვარ. ";
$name4 = "<hr>" .$name2. " კიდევ ერთხელ. "  .$name3;
echo $name4;
?>


<br>
<hr>


<?php
 // მრავალგანზომილებიანი მარტივი მასივი:
$arr[0][0]="ბოსტნეული";
$arr[0][1]="ხილი";
$arr[1][0]="გარგალი";
$arr[1][1]="ფორთოხალი";
$arr[1][2]="ბანანი";
$arr[2][0]="კიტრი";
$arr[2][1]="პომიდორი";
$arr[2][2]="გოგრა";
 // მასივის ელემენტების გამოტანა:
echo "<h3>".$arr[0][0].":</h3>";
for ($q=0; $q<=2; $q++) {
echo $arr[2][$q]."<br>";
}
echo "<h3>".$arr[0][1].":</h3>";
for ($w=0; $w<=2; $w++) {
    echo $arr[1][$w] . "<br>";
}
?>
</body>
</html>