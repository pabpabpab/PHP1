
<?php
require_once dirname(__FILE__, 2) . '/dblink.php';


$productId = getId();


$sql = "SELECT * FROM products WHERE id = " . $productId;
$result = mysqli_query($dbLink, $sql);
$row = mysqli_fetch_assoc($result);

$sql = "UPDATE products SET view_number = view_number + 1 WHERE id = " . $productId;
mysqli_query($dbLink, $sql);


//--------------------------------------------<фото товара>------------------------------------------------
$picturesHtml = '';
if (!empty($row['number_of_images'])) {

   $imgPath = '..';
   $imgFolder = $row['img_folder'];

   $sql = "SELECT * FROM products_images WHERE product_id = " . $productId;
   $result = mysqli_query($dbLink, $sql);
   $pictures = [];
   while ($row2 = mysqli_fetch_assoc($result)) {
      $pictures[] = "<a href='/?page=6&product_id={$productId}&img_id={$row2['id']}' target='_blank'><img src='{$imgPath}/{$imgFolder}/{$row2['img_name_info']}' class='small_img'></a>";
   }

   $picturesHtml = "<div class='product_img_div'>" . implode('', $pictures) . "</div>";
}
//--------------------------------------------</фото товара>------------------------------------------------

$productHtml = <<<phtml
<div class='product_one'>
    <h1>{$row['product_name']}</h1>
    <div class='product_price'>Цена: {$row['product_price']}</div>
    <div class='product_description'>{$row['product_description']}</div>
    {$picturesHtml}
    <div class='product_price'>Просмотров: {$row['view_number']}</div>
</div>
phtml;



//----------------------------------------<комментарии к товару>-------------------------------------------
$commentsHtml = '';
if (!empty($row['number_of_comments'])) {

   $sql = "SELECT * FROM products_comments WHERE product_id = " . $productId;
   $result = mysqli_query($dbLink, $sql);
   $comments = [];
   $commentsCounter = 0;
   while ($row3 = mysqli_fetch_assoc($result)) {
      $commentsCounter++;
      $comments[] = "<div class='comment'>{$commentsCounter}. {$row3['text']}</div>";
   }

   $commentsHtml = "<h2>Комментарии</h2>
   <div class='comments'>" . implode('', $comments) . "</div>";
}
//----------------------------------------</комментарии к товару>-------------------------------------------











if (!empty($_GET['errorsText'])) {
    echo "<div class='error'>" . $_GET['errorsText'] . "</div>";
}


echo $productHtml;

echo $commentsHtml;

echo <<<phtml
<a name='comments'></a>
<h2>Добавить комментарий</h2>
<form method='post' action='/?page=9&product_id={$productId}'>
    <textarea placeholder='Комментарий' name='comment' class='field'></textarea><br><br>
    <input type='submit' name='addcomment' class='field'>
</form>
phtml;

?>

