
<?php


function showBigPicture($dirname, $imgId) {
   GLOBAL $dbLink;
   $sql = "SELECT * FROM gallery WHERE id={$imgId}";
   $result = mysqli_query($dbLink, $sql);
   $row = mysqli_fetch_assoc($result);

   $number_of_viewings = $row['number_of_viewings'] + 1;
   $sql = "UPDATE gallery SET number_of_viewings = {$number_of_viewings} WHERE id = {$imgId}";
   mysqli_query($dbLink, $sql);


   return "<div class='big_img_div'>
     <img src='./{$dirname}/{$row['name_of_big_img']}' class='big_img'>
     <div class='view'>просмотров {$number_of_viewings}</div>
   </div>";
}



$dbLink = mysqli_connect('localhost', 'root', 'root', 'gbphp');

$imgId = (int) $_GET['img_id'];
$bigPictureHtml = showBigPicture($uploadDir, $imgId);

mysqli_close($dbLink);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <style>
        body {
          font-size: 1rem;
        }
        .big_img {
          align: center;
        }
        .big_img_div {
          display: flex;
          align-items: center;
          flex-direction: column;
          height: 100vh;
          width: 100%;
        }
        .view {
          font-size: 25px;
          font-weight: bold;
        }
    </style>
    <title>One picture</title>
</head>
<body>

<?php
  echo $bigPictureHtml;
?>

</body>
</html>