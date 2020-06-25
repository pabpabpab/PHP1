<?php
function indexAction() {

    $_SESSION['cart']['count'] = array_sum($_SESSION['cart']['goods']);


    # $_SESSION['cart']['goods'] это массив вида
    # ['product_id' => quantity, 'product_id' => quantity, ...]
    $idSet = implode(', ', array_keys($_SESSION['cart']['goods']));
    $result = getProductsByIdSet($idSet);


    if (!empty($result)) {
        $productsHtml = renderTmpl('tcart.php', [
           'result' => $result,
        ]);
        echo render('tgeneral.php', [
            'title' => 'Корзина',
            'h1' => 'Корзина',
            'html' => $productsHtml,
        ]);
    } else {
        echo render('tgeneral.php', [
            'title' => 'Корзина',
            'h1' => 'Корзина',
            'html' => 'Корзина пуста.',
        ]);
    }
}



function addToCartAction() {

	$productId = getId('product_id');

	if ($productId == 0) {
	   header("Location: /?p=catalog");
       exit;
	}

    if (!isset($_SESSION['cart']['goods'])) {
    	$_SESSION['cart']['goods'] = [];
    }

	if (array_key_exists($productId, $_SESSION['cart']['goods'])) {
		$_SESSION['cart']['goods'][$productId]++;
	} else {
		$_SESSION['cart']['goods'][$productId] = 1;
	}

	header("Location: /?p=cart");
    exit;
}



function deleteItemAction() {

    $productId = getId('product_id');

    unset($_SESSION['cart']['goods'][$productId]);

	header("Location: /?p=cart");
    exit;
}



function saveAction() {

   $_SESSION['cart']['goods'] = [];

   foreach ($_POST[goodsQuantity] as $productId => $quantity) {
      $productId = (int) $productId;
      $quantity = (int) $quantity;
      if ($productId > 0 && $quantity > 0) {
         $_SESSION['cart']['goods'][$productId] = $quantity;
      }
   }

   header("Location: /?p=cart");
   exit;
}