<?php
$title = 'Добавить товар';


$errorsText = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!allKeysExist(['name', 'price', 'description'], $_POST)) {
        header('Location: /?page=4');
        exit();
    }

    $name = stripInjection($_POST['name']);
    $price = getNumeric($_POST['price']);
    $description = stripInjection($_POST['description']);

    if (empty($name)) {
        $errorsText .= 'Не указано наименование товара.<br>';
    }
    if (empty($price)) {
        $errorsText .= 'Не указана цена товара.<br>';
    }
    if (empty($description)) {
        $errorsText .= 'Не указано описание товара.<br>';
    }


    if (!empty($errorsText)) {
       header("Location: /?page=4&errorsText={$errorsText}");
       exit;
    }


    require_once dirname(__FILE__, 2) . '/dblink.php';


    $sql = "INSERT INTO
            products
                (product_name, product_price, product_description)
            VALUES
                ('$name', $price, '$description')";
    mysqli_query($dbLink, $sql);
    $product_id = mysqli_insert_id($dbLink);



    if (empty($product_id)) {
       $errorsText = 'Товар не добавился.';
       header("Location: /?page=4&errorsText={$errorsText}");
       exit;
    }


    $htmlFormFieldName = 'userfile';
    if (!empty($_FILES[$htmlFormFieldName]['name'][0])) {
        require_once dirname(__FILE__, 2) . '/engine/multiple_upload_functions.php';

        $imgFolder = 1;
        $imgFolderPath = dirname(__FILE__, 2) . '/' . $imgFolder;
        checkFolder($imgFolderPath);

        $maxImgWeightInMb = 10;
        list($correctImages, $imgErrors) = myMultipleUpload($imgFolderPath, $htmlFormFieldName, $maxImgWeightInMb, $product_id);


        if (!empty($correctImages)) {
            foreach ($correctImages as $imgName) {
               $sql = "INSERT INTO
               products_images
                   (product_id, img_name_info)
               VALUES
                   ($product_id, '$imgName')";
               mysqli_query($dbLink, $sql);
            }

            $number_of_images = count($correctImages);
            $sql = "UPDATE products SET img_folder = {$imgFolder}, number_of_images = {$number_of_images}, main_img_name = '{$correctImages[0]}' WHERE id = {$product_id}";
            mysqli_query($dbLink, $sql);
        }


        if (!empty($imgErrors)) {
            $errorsText .= implode("<br>", $imgErrors);
        }
    }



    header("Location: /?page=5&id={$product_id}&errorsText={$errorsText}");
    exit;
}




if (!empty($_GET['errorsText'])) {
    $errorsText = "<div class='error'>" . $_GET['errorsText'] . "</div>";
}


echo $errorsText;
?>


<h1>Добавить товар</h1>
<form enctype='multipart/form-data' method='post' action='/?page=4'>
    <input type='text' placeholder='наименование товара' name='name' class='field'><br><br>
    <input type='text' placeholder='цена товара' name='price' class='field'><br><br>
    <textarea placeholder='описание товара' name='description' class='field'></textarea><br><br>
    <div class='hint'>можно выбрать несколько фото</div>
    <input type='file' name='userfile[]' multiple class='field'><br><br>
    <input type='submit' name='addproduct' class='field'>
</form>