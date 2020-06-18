<?php
require("upload_and_gallery_functions.php");

$dbLink = mysqli_connect('localhost', 'root', 'root', 'gbphp');


$htmlFormFieldName = 'userFile';
$maxImgWeightInMb = 10;
if (!empty($_FILES)) {
    $errors = myUpload($uploadDir, $htmlFormFieldName, $maxImgWeightInMb);
    $errorsText = implode("<br>", $errors);
}


$scriptName = basename($_SERVER['SCRIPT_NAME']);
$galleryHtml = readGalleryFromDatabase($uploadDir, $scriptName);


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
        .small_img {
            width: 100px;
            margin: 10px;
        }
        .gallery {
            display: flex;
            align-items: center;
            margin: 30px 0;
        }
        .error {
          align: center;
          margin: 30px 0;
        }
    </style>
    <title>Gallery</title>
</head>
<body>

<?php
if (!empty($errorsText)) {
   echo "<div class='error'>$errorsText</div>";
}
?>

<form enctype="multipart/form-data" action="<?php echo $scriptName; ?>" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxImgWeightInMb * 1024 * 1024; ?>" />
    Отправить этот файл: <input name="<?php echo $htmlFormFieldName; ?>" type="file" />
    <input type="submit" name="submit" value="Отправить файл" />
</form>

<div class="gallery">
    <?php echo $galleryHtml; ?>
</div>

</body>
</html>