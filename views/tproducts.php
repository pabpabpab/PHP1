<?php

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
   $imgHtml = '';
   if ($row['number_of_images'] > 0) {
      $imgHtml = "<a href='/?p=single_product&id={$row['id']}'><img src='./{$row['img_folder']}/{$row['main_img_name']}' class='small_img'></a>";
   }

   $products[] = <<<phtml
   <div class='catalog_item'>
      <div><a href='/?p=single_product&id={$row['id']}' class='catalog_name_link'>{$row['product_name']}</a></div>
      {$imgHtml}
      <div class='catalog_price'>{$row['product_price']}&#8381;</div>
      <div><a href='/?p=single_product&id={$row['id']}#comments' class='catalog_name_link'>Комментариев {$row['number_of_comments']}</a></div>
      <div><a href='/?p=personal_area&a=deleteProduct&id={$row['id']}' class='delete_link'>удалить</a></div>
   </div>
phtml;
}

echo "<div class='catalog'>" . implode('', $products) . "</div>";