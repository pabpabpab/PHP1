<?php

$products = [];
$_SESSION['cart']['totalPrice'] = 0;


while ($row = mysqli_fetch_assoc($result)) {

   $imgHtml = '';
   if ($row['number_of_images'] > 0) {
      $imgHtml = "<a href='/?p=single_product&id={$row['id']}'><img src='./{$row['img_folder']}/{$row['main_img_name']}' class='cart_img'></a>";
   }

   $productId = $row['id'];
   $thisGoodsPrice = number_format($row['product_price'] * $_SESSION['cart']['goods'][$productId] , 2, '.', '');
   $_SESSION['cart']['totalPrice'] += $thisGoodsPrice;

   $products[] = <<<phtml
   <tr>
   <td>
      <div class='cart_product'>
        <div><a href='/?p=single_product&id={$row['id']}' class='catalog_name_link'>{$row['product_name']}</a></div>
        {$imgHtml}
        <div class='catalog_price'>{$row['product_price']}&#8381;</div>
      </div>
   </td>
   <td>
      <input type='text' name='goodsQuantity[{$row['id']}]' value='{$_SESSION['cart']['goods'][$productId]}' class='cart_input'>
   </td>
   <td>
      {$thisGoodsPrice}&#8381;
   </td>
   <td>
      <a href='/?p=cart&a=deleteItem&product_id={$row['id']}' class='catalog_name_link'>Удалить</a>
   </td>
   </tr>
phtml;
}



$_SESSION['cart']['totalPrice'] = number_format($_SESSION['cart']['totalPrice'], 2, '.', '');

echo "<form method='post' action='/?p=cart&a=save'>
         <table class='cart'>" . implode('', $products) . "</table>
         <div class='totalPrice'>
            Итого: {$_SESSION['cart']['totalPrice']}&#8381;
         </div>
         <div class='totalPrice'>
           <input type='submit' value='Сохранить изменения' class='cart_submit'>
         </div>
      </form>
      ";