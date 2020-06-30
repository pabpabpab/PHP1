<?php
function indexAction() {
    $row = getOneProduct(getId());
    $imagesResult = getProductImages(getId());
    $commentsResult = getProductComments(getId());

    if (!isAdmin()) {
       $sql = "UPDATE products SET view_number = view_number + 1 WHERE id = " . getId();
       mysqli_query(getLink(), $sql);
    }

    $singleProductHtml = renderTmpl('tsingle_product.php', [
       'row' => $row,
       'imagesResult' => $imagesResult,
       'commentsResult' => $commentsResult
    ]);

    echo render('tgeneral.php', [
        'title' => $row['product_name'],
        'h1' => $row['product_name'],
        'html' => $singleProductHtml,
    ]);
}


function showBigImgAction() {
    $productId = getId('product_id');
    $imgId = getId('img_id');

    // product_name, img_folder
    $row = getOneProduct($productId);
    $row2 = getOnePicture($imgId);


    $bigPictureHtml = renderTmpl('tbig_picture.php', [
       'row' => $row,
       'row2' => $row2,
    ]);

    echo render('tgeneral.php', [
        'title' => $row['product_name'],
        'h1' => $row['product_name'],
        'html' => $bigPictureHtml,
    ]);
}


function addcommentAction() {
    $productId = getId('product_id');

    if (empty($productId)) {
       redirect('/?p=catalog');
       return;
    }

    if (empty($_POST['comment'])) {
       setMSG('Не указан комментарий.');
       redirect("/?p=single_product&id={$productId}");
       return;
    }

    $comment = stripInjection($_POST['comment']);

    $sql = "INSERT INTO products_comments (product_id, text) VALUES ($productId, '$comment')";
    mysqli_query(getLink(), $sql);
    $comment_id = mysqli_insert_id(getLink());

    if (empty($comment_id)) {
       setMSG('Комментарий не добавился.');
       redirect("/?p=single_product&id={$productId}");
       return;
    }

    $sql = "UPDATE products SET number_of_comments = number_of_comments + 1 WHERE id = " . $productId;
    mysqli_query(getLink(), $sql);

    redirect("/?p=single_product&id={$productId}");
}