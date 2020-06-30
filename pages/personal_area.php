<?php
function indexAction() {
    if (!$_SESSION['user']['authorized']) {
        redirect(' /');
        return;
    }

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет',
        'h1' => 'Личный кабинет',
        'msg' => getMSG(),
        'privateMenu' => getPrivateMenu(),
        'privateContent' => ''
    ]);
}



function myProductsAction() {
    if (!isAdmin()) {
        redirect('');
        return;
    }

    $h2 = 'Мои товары';

	$result = getProducts($_SESSION['user']['id']);

    $_SESSION['user']['number_of_products'] = mysqli_num_rows($result);

	$productsHtml = renderTmpl('tproducts.php', [
       'result' => $result,
    ]);

    $privateContent = renderTmpl('tprivate_page.php', [
       'h2' => $h2,
       'html' => $productsHtml,
    ]);

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет / Мои товары',
        'h1' => 'Личный кабинет',
        'msg' => getMSG(),
        'privateMenu' => getPrivateMenu(),
        'privateContent' => $privateContent,
    ]);
}



function newProductAction() {
    if (!isAdmin()) {
        redirect('');
        return;
    }

    $h2 = 'Добавить товар';

    $formHtml = renderTmpl('tnew_product_form.php', []);

    $privateContent = renderTmpl('tprivate_page.php', [
       'h2' => $h2,
       'html' => $formHtml,
    ]);

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет / Добавить товар',
        'h1' => 'Личный кабинет',
        'msg' => getMSG(),
        'privateMenu' => getPrivateMenu(),
        'privateContent' => $privateContent,
    ]);
}




function addProductAction() {
    if (!isAdmin()) {
        redirect('');
        return;
    }

    $userId = getInt($_SESSION['user']['id']);

    if ($userId == 0) {
        redirect('/?p=login');
        return;
    }

    $name = stripInjection($_POST['name']);
    $price = getNumeric($_POST['price']);
    $description = stripInjection($_POST['description']);

    $error = '';
    if (empty($name)) {
        $error .= 'Не указано наименование товара.<br>';
    }
    if (empty($price)) {
        $error .= 'Не указана цена товара.<br>';
    }
    if (empty($description)) {
        $error .= 'Не указано описание товара.<br>';
    }
    if (!empty($error)) {
        setMSG($error);
        redirect('/?p=personal_area&a=newProduct');
        return;
    }

    $sql = "INSERT INTO
            products
                (user_id, product_name, product_price, product_description)
            VALUES
                ($userId, '$name', $price, '$description')";
    mysqli_query(getLink(), $sql);
    $product_id = mysqli_insert_id(getLink());


    if (empty($product_id)) {
        setMSG('Товар не добавился.');
        redirect('/?p=personal_area&a=newProduct');
        return;
    }

    $_SESSION['user']['number_of_products'] = setUserNumberOfProducts($userId);

    $htmlFormImgFieldName = 'userfile';
    if (!empty($_FILES[$htmlFormImgFieldName]['name'][0])) {
        $maxImgWeightInMb = 10;
        $imgFolder = 1;
        $imgFolderPath = './';
        checkFolder($imgFolderPath . $imgFolder);

        $imgErrors = saveUploadedImages($imgFolderPath, $imgFolder, $htmlFormImgFieldName, $maxImgWeightInMb, $product_id);

        if (!empty($imgErrors)) {
            $error = implode("<br>", $imgErrors);
            setMSG($error);
        }
    }

    redirect('/?p=personal_area&a=myProducts');
}



function saveUploadedImages($imgFolderPath, $imgFolder, $htmlFormFieldName, $maxImgWeightInMb, $product_id) {
    include_once dirname(__DIR__) . '/engine/multiple_upload_functions.php';

    list($correctImages, $imgErrors) = myMultipleUpload($imgFolderPath, $imgFolder, $htmlFormFieldName, $maxImgWeightInMb, $product_id);

    if (!empty($correctImages)) {

        foreach ($correctImages as $imgName) {
            $sql = "INSERT INTO
           products_images
               (product_id, img_name_info)
           VALUES
               ($product_id, '$imgName')";
            mysqli_query(getLink(), $sql);
        }

        $number_of_images = count($correctImages);

        $sql = "UPDATE
        products
        SET
        img_folder = {$imgFolder},
        number_of_images = {$number_of_images},
        main_img_name = '{$correctImages[0]}'
        WHERE
        id = {$product_id}";
        mysqli_query(getLink(), $sql);
    }

    return $imgErrors;
}



function deleteProductAction() {
   if (!isAdmin()) {
        redirect('');
        return;
   }

   $userId = getInt($_SESSION['user']['id']);

   if ($userId == 0) {
       redirect('/?p=login');
       exit;
   }

   $productId = getId();
   $row = getOneProduct($productId);

   if (empty($row['product_name'])) {
      setMSG("В базе нет товара с id = " . $productId);
      redirect('/?p=personal_area&a=myProducts');
      return;
   }

   // на случай если несколько админов..
   // но можно убрать эту проверку.
   if ($userId != $row['user_id']) {
      setMSG("У вас нет прав на удаление товара с id = " . $productId);
      redirect('/?p=personal_area&a=myProducts');
      return;
   }

   if (!empty($row['number_of_images'])) {
       $imgPath = '.';
       $imgFolder = $row['img_folder'];
       deleteProductImages($productId, $imgPath, $imgFolder);
   }

   $sql = "DELETE FROM products WHERE id = " . $productId;
   mysqli_query(getLink(), $sql);

   $_SESSION['user']['number_of_products'] = setUserNumberOfProducts($userId);

   redirect('/?p=personal_area&a=myProducts');
}


function deleteProductImages($productId, $imgPath, $imgFolder) {
    $result = getProductImages($productId);
    $deleteError = '';

    while ($row = mysqli_fetch_assoc($result)) {
        $pictureFile = "{$imgPath}/{$imgFolder}/{$row['img_name_info']}";
        if (!is_file($pictureFile)) {
            setMSG("Не удалось найти фото товара " . $pictureFile . ". Удаление отменено.");
            redirect('/?p=personal_area&a=myProducts');
            exit();
        }
        if (!unlink($pictureFile)) {
            $deleteError .= "Не удалось удалить фото товара " . $pictureFile . "<br>";
        }
    }

    if (!empty($deleteError)) {
        setMSG($deleteError);
    }

    $sql = "DELETE FROM products_images WHERE product_id = " . $productId;
    mysqli_query(getLink(), $sql);
}



