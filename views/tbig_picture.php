
<?php
$imgPath = '.';
$imgFolder = $row['img_folder'];
echo <<<phtml
<div class='product_img_div'><img src='{$imgPath}/{$imgFolder}/{$row2['img_name_info']}' class='big_img'></div>
phtml;

