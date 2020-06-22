
<?php
require_once dirname(__FILE__, 2) . '/dblink.php';

$productId = getId('product_id');

$sql = "SELECT product_name, img_folder FROM products WHERE id = " . $productId;
$result = mysqli_query($dbLink, $sql);
$row = mysqli_fetch_assoc($result);


$imgPath = '..';
$imgFolder = $row['img_folder'];

$sql = "SELECT * FROM products_images WHERE product_id = " . $productId;
$result = mysqli_query($dbLink, $sql);
$row2 = mysqli_fetch_assoc($result);


echo <<<phtml
<h1>{$row['product_name']}</h1>
<div class='product_img_div'><img src='{$imgPath}/{$imgFolder}/{$row2['img_name_info']}' class='big_img'></div>
phtml;
?>

