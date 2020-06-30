<?php
// Просмотр одного заказа
function indexAction() {
    if (!$_SESSION['user']['authorized']) {
        setMSG('Сессия истекла. Нужно авторизоваться.');
        redirect('/?p=login');
        return;
    }

    $orderId = getId();
    if ($orderId == 0) {
        redirect('');
        return;
    }

    $orderRow = getOneOrder($orderId);

    if (!isAdmin() && $_SESSION['user']['id'] != $orderRow['user_id']) {
        redirect('');
        return;
    }

    $items = json_decode($orderRow['items'], true);

    $idSet = implode(', ', array_keys($items));
    $result = getProductsByIdSet($idSet);

    $productsHtml = renderTmpl('torder.php', [
        'result' => $result,
        'orderRow' => $orderRow,
        'orderItems' => $items,
    ]);

    $privateContent = renderTmpl('tprivate_page.php', [
        'h2' => 'Заказ номер ' . $orderRow['id'],
        'html' => $productsHtml,
    ]);

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет / Заказ номер ' . $orderRow['id'],
        'h1' => 'Личный кабинет',
        'msg' => getMSG(),
        'privateMenu' => getPrivateMenu(),
        'privateContent' => $privateContent,
    ]);
}



// Создание заказа
function setAction() {
    if (!$_SESSION['user']['authorized']) {
        setMSG('Сессия истекла. Нужно авторизоваться.');
        redirect('/?p=login');
        return;
    }

    $userId = $_SESSION['user']['id'];
    $items = json_encode($_SESSION['cart']['goods']);
    $totalPrice = calcCartTotalPrice($_SESSION['cart']['goods']);

    $sql = "INSERT INTO
            orders
                (user_id, items, total_price, status)
            VALUES
                ($userId, '$items', $totalPrice, 1)";
    mysqli_query(getLink(), $sql);
    $orderId = mysqli_insert_id(getLink());

    if ($orderId == 0) {
        setMSG('Не удалось создать заказ.');
        redirect('/?p=cart');
        return;
    }

    if (isAdmin()) {
        $_SESSION['user']['orders_count'] = userOrdersCounter();
    } else {
        $_SESSION['user']['orders_count'] = setUserNumberOfOrders($userId);
    }

    resetCart();
    redirect("/?p=order&id={$orderId}");
}



// Изменить статус заказа
function changeStatusAction() {
    if (!$_SESSION['user']['authorized']) {
        setMSG('Сессия истекла. Нужно авторизоваться.');
        redirect('/?p=login');
        return;
    }
    if (!isAdmin()) {
        redirect('/?p=personal_area');
        return;
    }
    $orderId = getId('orderId');
    if ($orderId == 0) {
        redirect('/?p=orders');
        return;
    }
    $status = getInt($_POST['status']);
    if (empty(getOrderStatuses()[$status])) {
        redirect('');
        return;
    }

    $sql = "UPDATE
        orders
        SET
        status = {$status} 
        WHERE
        id = {$orderId}";
    mysqli_query(getLink(), $sql);

    redirect('/?p=order&id={$orderId}');
}



// Получить данные одного заказа
function getOneOrder($orderId) {
    $sql = 'SELECT * FROM orders WHERE id = ' . $orderId;
    $result = mysqli_query(getLink(), $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}
// Посчитать сумму заказа / корзины
function calcCartTotalPrice($cart) {
    $idSet = implode(', ', array_keys($cart));
    $result = getProductsByIdSet($idSet);
    $totalPrice = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['id'];
        $totalPrice += $row['product_price'] * $cart[$productId];
    }
    return $totalPrice;
}
