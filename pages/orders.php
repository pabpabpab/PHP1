<?php

// Список заказов
function indexAction() {
    if (!$_SESSION['user']['authorized']) {
        redirect('/?p=login');
        return;
    }

    if (isAdmin()) {
        $result = getOrders();
    } else {
        $result = getOrders($_SESSION['user']['id']);
    }

    // $_SESSION['user']['orders_count'] = mysqli_num_rows($result);

    if (isAdmin()) {
        $_SESSION['user']['orders_count'] = userOrdersCounter();
    } else {
        $_SESSION['user']['orders_count'] = setUserNumberOfOrders($_SESSION['user']['id']);
    }

    $ordersHtml = 'Нет заказов.';
    if (!empty($_SESSION['user']['orders_count'])) {
        $ordersHtml = renderTmpl('torders.php', [
            'result' => $result,
        ]);
    }

    $privateContent = renderTmpl('tprivate_page.php', [
        'h2' => 'Мои заказы',
        'html' => $ordersHtml,
    ]);

    echo render('tpersonal_area.php', [
        'title' => 'Личный кабинет / Мои заказы',
        'h1' => 'Личный кабинет',
        'msg' => getMSG(),
        'privateMenu' => getPrivateMenu(),
        'privateContent' => $privateContent,
    ]);
}



function getOrders($userId = 0) {
    $where = '';
    if ($userId > 0) {
        $where = " WHERE user_id = " . $userId;
    }
    $sql = 'SELECT * FROM orders' . $where;
    $result = mysqli_query(getLink(), $sql);
    return $result;
}