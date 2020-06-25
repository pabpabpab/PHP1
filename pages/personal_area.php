<?php
function indexAction() {
    $error = '';
    if (!empty($_GET['error'])) {
    	$error = $_GET['error'];
    }

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет',
        'h1' => 'Личный кабинет',
        'error' => $error,
        'privateMenu' => getPrivateMenu(),
        'privatePage' => ''
    ]);
}


function getPrivateMenu() {
    return renderTmpl('tprivate_menu.php', [
       'userName' => $_SESSION['user']['name'],
       'userNumberOfProducts' => $_SESSION['user']['number_of_products'],
    ]);
}


function myProductsAction() {
    $error = '';
    if (!empty($_GET['error'])) {
        $error = $_GET['error'];
    }

	$h2 = 'Мои товары';

	$result = getProducts($_SESSION['user']['id']);

    $_SESSION['user']['number_of_products'] = mysqli_num_rows($result);

	$productsHtml = renderTmpl('tproducts.php', [
       'result' => $result,
    ]);

    $privatePage = renderTmpl('tprivate_page.php', [
       'h2' => $h2,
       'html' => $productsHtml,
    ]);

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет / Мои товары',
        'h1' => 'Личный кабинет',
        'error' => $error,
        'privateMenu' => getPrivateMenu(),
        'privatePage' => $privatePage,
    ]);
}



function newProductAction() {
    $h2 = 'Добавить товар';

    $formHtml = renderTmpl('tnew_product_form.php', []);

    $privatePage = renderTmpl('tprivate_page.php', [
       'h2' => $h2,
       'html' => $formHtml,
    ]);


    $error = '';
    if (!empty($_GET['error'])) {
        $error = $_GET['error'];
    }

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет / Добавить товар',
        'h1' => 'Личный кабинет',
        'error' => $error,
        'privateMenu' => getPrivateMenu(),
        'privatePage' => $privatePage,
    ]);
}




function deleteProductAction() {
   include_once dirname(__DIR__) . '/engine/valid_data_functions.php';

   $userId = getInt($_SESSION['user']['id']);

   if ($userId == 0) {
       header("Location: /?p=login");
       exit;
    }

   $productId = getId();
   $row = getOneProduct($productId);

   if (empty($row['product_name'])) {
      $error = "В базе нет товара с id = " . $productId;
      header("Location: /?p=personal_area&a=myProducts&error={$error}");
      exit;
   }

   if ($userId != $row['user_id']) {
      $error = "У вас нет прав на удаление товара с id = " . $productId;
      header("Location: /?p=personal_area&a=myProducts&error={$error}");
      exit;
   }

   if (!empty($row['number_of_images'])) {
      $imgPath = '.';
      $imgFolder = $row['img_folder'];

      $sql = "SELECT img_name_info FROM products_images WHERE product_id = " . $productId;
      $result = mysqli_query(getLink(), $sql);
      while ($row2 = mysqli_fetch_assoc($result)) {
         $pictureFile = "{$imgPath}/{$imgFolder}/{$row2['img_name_info']}";
         if (!unlink($pictureFile)) {
            $error = "Не удалось удалить фото товара " . $pictureFile . ". Удаление отменено.";
            header("Location: /?p=personal_area&a=myProducts&error={$error}");
            exit;
         }
      }
      $sql = "DELETE FROM products_images WHERE product_id = " . $productId;
      mysqli_query(getLink(), $sql);
   }

   $sql = "DELETE FROM products WHERE id = " . $productId;
   mysqli_query(getLink(), $sql);

   header("Location: /?p=personal_area&a=myProducts");
   exit;
}




function addProductAction() {
    include_once dirname(__DIR__) . '/engine/valid_data_functions.php';

    $userId = getInt($_SESSION['user']['id']);

    if ($userId == 0) {
       header("Location: /?p=login");
       exit;
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
       header("Location: /?p=personal_area&a=newProduct&error={$error}");
       exit;
    }

    $sql = "INSERT INTO
            products
                (user_id, product_name, product_price, product_description)
            VALUES
                ($userId, '$name', $price, '$description')";
    mysqli_query(getLink(), $sql);
    $product_id = mysqli_insert_id(getLink());


    if (empty($product_id)) {
       $error = 'Товар не добавился.';
       header("Location: /?p=personal_area&a=newProduct&error={$error}");
       exit;
    }

    $htmlFormImgFieldName = 'userfile';
    if (!empty($_FILES[$htmlFormImgFieldName]['name'][0])) {
       $maxImgWeightInMb = 10;
       $imgFolder = 1;
       $imgFolderPath = './';
       checkFolder($imgFolderPath . $imgFolder);

       $imgErrors = saveUploadedImages($imgFolderPath, $imgFolder, $htmlFormImgFieldName, $maxImgWeightInMb, $product_id);

       if (!empty($imgErrors)) {
           $error = implode("<br>", $imgErrors);
       }
    }

    header("Location: /?p=personal_area&a=myProducts&error={$error}");
    exit;
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