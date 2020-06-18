
<?php

/*
CREATE TABLE gallery ( id INT UNSIGNED NOT NULL AUTO_INCREMENT , img_folder INT UNSIGNED NOT NULL , name_of_small_img VARCHAR(30) NOT NULL , name_of_big_img VARCHAR(30) NOT NULL , weight_of_small_img INT UNSIGNED NOT NULL , weight_of_big_img INT UNSIGNED NOT NULL , number_of_viewings INT UNSIGNED NOT NULL DEFAULT '0', PRIMARY KEY (id), INDEX number_of_viewings (number_of_viewings)) ENGINE = InnoDB;
*/


$uploadDir = '1';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777)) {
        exit('Не могу создать папку галлереи.');
    }
}



if (!empty($_GET['show_big_img']) && ((int) $_GET['img_id'] > 0)) {
   include('one_picture.php');
} else {
   include('catalog.php');
}

?>
