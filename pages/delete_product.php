
<?php
require_once dirname(__FILE__, 2) . '/dblink.php';


$productId = getId();

$sql = "SELECT product_name, img_folder, number_of_images FROM products WHERE id = " . $productId;
$result = mysqli_query($dbLink, $sql);
$row = mysqli_fetch_assoc($result);



if (empty($row['product_name'])) {
   $errorsText = "В базе нет товара с id = " . $productId;
   header("Location: /?page=7&errorsText={$errorsText}");
   exit;
}




if (!empty($row['number_of_images'])) {
   $imgPath = dirname(__FILE__, 2);
   $imgFolder = $row['img_folder'];

   $sql = "SELECT img_name_info FROM products_images WHERE product_id = " . $productId;
   $result = mysqli_query($dbLink, $sql);
   while ($row2 = mysqli_fetch_assoc($result)) {
      $pictureFile = "{$imgPath}/{$imgFolder}/{$row2['img_name_info']}";
      if (!unlink($pictureFile)) {
         $errorsText = "Не удалось удалить фото товара " . $pictureFile . ". Удаление отменено.";
         header("Location: /?page=7&errorsText={$errorsText}");
         exit;
      }
   }
   $sql = "DELETE FROM products_images WHERE product_id = " . $productId;
   mysqli_query($dbLink, $sql);
}

$sql = "DELETE FROM products WHERE id = " . $productId;
mysqli_query($dbLink, $sql);


header("Location: /?page=7");
exit;

?>