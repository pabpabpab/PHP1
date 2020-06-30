<?php

//--------------------------------------------<фото товара>------------------------------------------------
$picturesHtml = '';
if (!empty($row['number_of_images'])) {

   $imgPath = '.';
   $imgFolder = $row['img_folder'];

   $pictures = [];
   while ($row2 = mysqli_fetch_assoc($imagesResult)) {
      $pictures[] = "<a href='/?p=single_product&a=showBigImg&product_id={$row['id']}&img_id={$row2['id']}' target='_blank'><img src='{$imgPath}/{$imgFolder}/{$row2['img_name_info']}' class='small_img'></a>";
   }

   $picturesHtml = "<div class='product_img_div'>" . implode('', $pictures) . "</div>";
}
//--------------------------------------------</фото товара>------------------------------------------------
//------------------------------------------------<товар>---------------------------------------------------
$productHtml = <<<phtml
<div class='product_one'>
    <div class='product_price'>Цена: {$row['product_price']}</div>
    <div class='product_description'>{$row['product_description']}</div>
    {$picturesHtml}
    <div class='product_price'>Просмотров: {$row['view_number']}</div>
</div>
phtml;
//------------------------------------------------</товар>---------------------------------------------------
//
//------------------------------------------------<addToCartLink>--------------------------------------------
$thisProductCartQuantity = '';
$productId = $row['id'];
if ($_SESSION['cart']['goods'][$productId] > 0) {
   $thisProductCartQuantity = ' (' . $_SESSION['cart']['goods'][$productId] . ')';
}
$addToCartLink = "<a href='/?p=cart&a=addToCart&product_id={$row['id']}' class='addtocart_link'>Добавить в корзину{$thisProductCartQuantity}</a>";
//------------------------------------------------</addToCartLink>--------------------------------------------
//
//----------------------------------------<комментарии к товару>---------------------------------------------
$commentsHtml = '';
if (!empty($row['number_of_comments'])) {
   $comments = [];
   $commentsCounter = 0;
   while ($row3 = mysqli_fetch_assoc($commentsResult)) {
      $commentsCounter++;
      $comments[] = "<div class='comment'>{$commentsCounter}. {$row3['text']}</div>";
   }

   $commentsHtml = "<h2>Комментарии</h2>
   <div class='comments'>" . implode('', $comments) . "</div>";
}
//----------------------------------------</комментарии к товару>-------------------------------------------
//--------------------------------------------<echo всего HTML>---------------------------------------------
if (!empty($_GET['error'])) {
    echo "<div class='error'>" . $_GET['error'] . "</div>";
}

echo $productHtml;

echo $addToCartLink;

echo $commentsHtml;

echo <<<phtml
<a name='comments'></a>
<h2>Добавить комментарий</h2>
<form method='post' action='/?p=single_product&a=addcomment&product_id={$row['id']}'>
    <textarea placeholder='Комментарий' name='comment' class='field'></textarea><br><br>
    <input type='submit' name='addcomment' class='field'>
</form>
phtml;
//---------------------------------------------</echo всего HTML>--------------------------------------------


