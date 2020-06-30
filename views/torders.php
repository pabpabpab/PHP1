<?php

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
   $status = getOrderStatuses()[$row['status']];
   $orders[] = <<<phtml
   <tr>
      <td><a href='/?p=order&id={$row['id']}' class='catalog_name_link'>Заказ номер {$row['id']}</a></td>
      <td class='catalog_price'>{$row['total_price']}&#8381;</td>
      <td class='catalog_price'>{$status}</td>      
   </tr>
phtml;
}

echo "<table class='cart w70p'>" . implode('', $orders) . "</table>";