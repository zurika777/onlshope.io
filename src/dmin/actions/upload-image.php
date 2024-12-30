<?php
defined('kasius') or die('mzgavsi gverdi ar moidzebna!');
$error_img = array();

if ($_FILES['upload_image']['error'] > 0)
{
    switch ($_FILES['upload_image']['error'])
    {
        case 1: $error_img[] = 'ფაილის ზომამ გადააჭარბა დაშვებულ ზომას UPLOAD_MAX_FILE_SIZE'; break;
        case 2: $error_img[] = 'ფაილის ზომამ გადააჭარბა დაშვებულ  MAX_FILE_SIZE'; break;
        case 3: $error_img[] = 'ფაილის ნაწილი ვერ ჩაიტვირთა'; break;
        case 4: $error_img[] = 'ფაილლი არ დამატებულა'; break;
        case 5: $error_img[] = 'დროებითი ფოლდერი არ არის'; break;
        case 6: $error_img[] = 'ფაილი დისკზე არ ჩაწერილა'; break;
        case 7: $error_img[] = 'PHP- გაფართოებამ ფაილის ჩაწერა შეაჩერა'; break;
    }
}else {
    if ($_FILES['upload_image']['type'] == 'image/jpeg' || $_FILES['upload_image']['type'] == 'image/jpg' || $_FILES['upload_image']['type'] == 'image/png')
    {
        $imgtext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['upload_image']['name']));
        $uploaddir = '../uploads_images/';
        // делаем имя файла
        $newfilename = $_POST['form_type'].'-'.$id.rand(10,100).'.'.$imgtext;
        // путь к файлу
        $uploadfile = $uploaddir.$newfilename;
//        echo "<tt><pre> - djflskdjf - ".print_r($uploadfile, true). "</pre></tt>";
        if (move_uploaded_file($_FILES['upload_image']['tmp_name'], $uploadfile)) {
            $update = mysqli_query($link,"UPDATE table_products SET images='$newfilename' WHERE products_id='$id'");
//            echo "<tt><pre> - djflskdjf - ".print_r($sth, true). "</pre></tt>";

        } else {
            $error_img[] = "Ошибка загрузки файла";
        }
    } else {
        $error_img[] = 'Допустимые расширения: jpeg, jpg, png';
    }


}
?>