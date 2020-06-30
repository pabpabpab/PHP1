<?php

$products = [];
$totalPrice = 0;


while ($row = mysqli_fetch_assoc($result)) {

    $imgHtml = '';
    if ($row['number_of_images'] > 0) {
        $imgHtml = "<a href='/?p=single_product&id={$row['id']}'><img src='./{$row['img_folder']}/{$row['main_img_name']}' class='cart_img'></a>";
    }

    $productId = $row['id'];
    $thisGoodsPrice = number_format($row['product_price'] * $orderItems[$productId] , 2, '.', '');


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
      {$orderItems[$productId]} шт.
   </td>
   <td>
      {$thisGoodsPrice}&#8381;
   </td>   
   </tr>
phtml;
}




$orderStatuses = getOrderStatuses();
$orderStatus = "Статус заказа: " . $orderStatuses[$orderRow['status']];
if (isAdmin()) {
    $orderStatus .= "<form method='post' action='/?p=order&a=changeStatus&orderId={$orderRow['id']}'>
      <select name='status' class='field'>
      <option></option>";
      foreach ($orderStatuses as $key => $value) {
          $orderStatus .= "<option value='{$key}'>$value</option>";
      }
      $orderStatus .= "
      </select>
      <input type='submit' value='Изменить' class='field'>
    </form>";
}
$orderStatusDiv = "<div>" . $orderStatus . "</div>";



$totalPrice = number_format($orderRow['total_price'], 2, '.', '');

echo "<table class='cart'>" . implode('', $products) . "</table>
      <div class='cart_bottom'>
         {$orderStatusDiv}
         <div class='totalPrice'>Итого: {$totalPrice}&#8381;</div>
      </div>";