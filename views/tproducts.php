<?php

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
   $productId = $row['id'];
   
   $imgHtml = '';
   if ($row['number_of_images'] > 0) {
      $imgHtml = "<a href='/?p=single_product&id={$productId}'><img src='./{$row['img_folder']}/{$row['main_img_name']}' class='small_img'></a>";
   }

   $deleteLink = '';
   if (isAdmin()) {
      $deleteLink = "<div><a href='/?p=personal_area&a=deleteProduct&id={$productId}' class='delete_link'>удалить</a></div>";
   }

   //-------------<addToCartLink>----------
   $thisProductCartQuantity = '';
   if ($_SESSION['cart']['goods'][$productId] > 0) {
       $thisProductCartQuantity = ' (' . $_SESSION['cart']['goods'][$productId] . ')';
   }
   $addToCartLink = "<div><a href='/?p=cart&a=addToCart&product_id={$productId}' class='catalog__addtocart_link'>Добавить в корзину{$thisProductCartQuantity}</a></div>";
    //-------------</addToCartLink>-----------

   $products[] = <<<phtml
   <div class='catalog_item'>
      <div><a href='/?p=single_product&id={$productId}' class='catalog_name_link'>{$row['product_name']}</a></div>
      {$imgHtml}
      <div class='catalog_price'>{$row['product_price']}&#8381;</div>
      <div><a href='/?p=single_product&id={$productId}#comments' class='catalog_name_link'>Комментариев {$row['number_of_comments']}</a></div>
      {$addToCartLink}
      {$deleteLink} 
   </div>
phtml;
}

echo "<div class='catalog'>" . implode('', $products) . "</div>";