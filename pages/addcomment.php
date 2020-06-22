<?php

$productId = getId('product_id');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!allKeysExist(['comment', 'addcomment'], $_POST)) {
        header('Location: /?page=5');
        exit();
    }


    $comment = stripInjection($_POST['comment']);
    if (empty($comment)) {
        $errorsText = 'Вы не указали комментарий.<br>';
        header("Location: /?page=5&id={$productId}&errorsText={$errorsText}");
        exit;
    }


    require_once dirname(__FILE__, 2) . '/dblink.php';


    $sql = "INSERT INTO
            products_comments
                (product_id, text)
            VALUES
                ($productId, '$comment')";
    mysqli_query($dbLink, $sql);
    $comment_id = mysqli_insert_id($dbLink);



    if (empty($comment_id)) {
       $errorsText = 'Комментарий не добавился.';
       header("Location: /?page=5&id={$productId}&errorsText={$errorsText}");
       exit;
    }


    $sql = "UPDATE products SET number_of_comments = number_of_comments + 1 WHERE id = " . $productId;
    mysqli_query($dbLink, $sql);
}


header("Location: /?page=5&id={$productId}");
exit;

?>

