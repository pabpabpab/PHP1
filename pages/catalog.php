<?php
$title = 'Каталог товаров';
require_once dirname(__FILE__, 2) . '/dblink.php';

$sql = "SELECT * FROM products";
$result = mysqli_query($dbLink, $sql);

$imgPath = '..';
$products = [];
while ($row = mysqli_fetch_assoc($result)) {

   $imgHtml = '';
   if ($row['number_of_images'] > 0) {
      $imgHtml = "<a href='/?page=5&id={$row['id']}'><img src='{$imgPath}/{$row['img_folder']}/{$row['main_img_name']}' class='small_img'></a>";
   }

   $products[] = <<<phtml
   <div class='catalog_item'>
      <div><a href='/?page=5&id={$row['id']}' class='catalog_name_link'>{$row['product_name']}</a></div>
      {$imgHtml}
      <div class='catalog_price'>{$row['product_price']}&#8381;</div>
      <div><a href='/?page=5&id={$row['id']}#comments' class='catalog_name_link'>Комментариев {$row['number_of_comments']}</a></div>
      <div><a href='/?page=8&id={$row['id']}' class='delete_link'>удалить</a></div>
   </div>
phtml;
}


if (!empty($_GET['errorsText'])) {
    echo "<div class='error'>" . $_GET['errorsText'] . "</div>";
}


echo "<div class='catalog'>" . implode('', $products) . "</div>";
?>

