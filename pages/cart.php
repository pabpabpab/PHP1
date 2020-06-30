<?php
function indexAction() {
    // проверка на существование в базе такого id
    $_SESSION['cart']['count'] = 0;
    foreach($_SESSION['cart']['goods'] as $productId => $quantity) {
        if (!productExists($productId)) {
            unset($_SESSION['cart']['goods'][$productId]);
            continue;
        }
        $_SESSION['cart']['count'] += $quantity;
    }

    # $_SESSION['cart']['goods'] это массив вида
    # ['product_id' => quantity, 'product_id' => quantity, ...]
    $idSet = implode(', ', array_keys($_SESSION['cart']['goods']));
    $result = getProductsByIdSet($idSet);

    if (empty($result)) {
        resetCart();
        echo render('tgeneral.php', [
            'title' => 'Корзина',
            'h1' => 'Корзина',
            'html' => 'Корзина пуста.',
        ]);
        return;
    }

    $productsHtml = renderTmpl('tcart.php', [
        'result' => $result,
    ]);
    echo render('tgeneral.php', [
        'title' => 'Корзина',
        'h1' => 'Корзина',
        'html' => $productsHtml,
    ]);
}



function addToCartAction() {
	$productId = getId('product_id');

	if (!productExists($productId)) {
	    redirect('');
	    return;
	}

    if (!isset($_SESSION['cart']['goods'])) {
        resetCart();
    }

	if (array_key_exists($productId, $_SESSION['cart']['goods'])) {
		$_SESSION['cart']['goods'][$productId]++;
	} else {
		$_SESSION['cart']['goods'][$productId] = 1;
	}

    redirect('/?p=cart');
}



function deleteItemAction() {
    $productId = getId('product_id');
    unset($_SESSION['cart']['goods'][$productId]);
    redirect('/?p=cart');
}



function saveAction() {
   $_SESSION['cart']['goods'] = [];
   $_SESSION['cart']['count'] = 0;

   foreach ($_POST[goodsQuantity] as $productId => $quantity) {
       $productId = (int) $productId;
       $quantity = (int) $quantity;

       if (!productExists($productId)) {
           unset($_SESSION['cart']['goods'][$productId]);
           continue;
       }

       if ($productId > 0 && $quantity > 0) {
          $_SESSION['cart']['goods'][$productId] = $quantity;
       }

       $_SESSION['cart']['count'] += $quantity;
   }

   if (!empty($_POST['setOrder']) && $_SESSION['cart']['count'] > 0) {
       redirect('/?p=order&a=set');
       return;
   }

   redirect('/?p=cart');
}

