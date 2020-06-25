<?php

function run()
{
    sessionInit();

    $page = 'index';
    if (!empty($_GET['p'])) {
        $page = $_GET['p'];
    }

    $fileName = getFileName($page);

    if (!is_file($fileName)) {
        $fileName = getFileName('index');
    }


    include $fileName;

    $action = 'index';
    if (!empty($_GET['a'])) {
        $action = $_GET['a'];
    }

    $action .= 'Action';

    if (!function_exists($action)) {
        $action = 'indexAction';
    }

    return $action();
}

function getFileName($file)
{
    return dirname(__DIR__) . '/pages/' . $file . '.php';
}

function render($template, $params = [], $layout = 'main.php')
{
    $content = renderTmpl($template, $params);
    $layout = 'layouts/' . $layout;
    $title = 'Test';
    if (!empty($params['title'])) {
        $title = $params['title'];
    }
    return renderTmpl($layout, [
        'content' => $content,
        'title' => $title,
    ]);
}

function renderTmpl($template, $params = [])
{
    ob_start();
    extract($params);
    include dirname(__DIR__) . '/views/' . $template;
    return ob_get_clean();
}



function getLink() {
    static $link;
    if (empty($link)) {
        $link = mysqli_connect('localhost', 'root', 'root','gbshop');
    }
    return $link;
}


function sessionInit() {

    session_start();

    if (!isset($_SESSION['cart']['count'])) {
        $_SESSION['cart']['count'] = 0;
    }

    if (!isset($_SESSION['cart']['totalPrice'])) {
        $_SESSION['cart']['totalPrice'] = 0;
    }

    if (!isset($_SESSION['cart']['goods'])) {
        $_SESSION['cart']['goods'] = [];
    }
}


function getId($key = 'id') {
    if (!empty($_GET[$key])) {
        return (int) $_GET[$key];
    }
    return 0;
}

function getUserInfo($userId) {
    $sql = 'SELECT * FROM users WHERE id = ' . $userId;
    $result = mysqli_query(getLink(), $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function getProducts($userId = 0) {
    $where = '';
    if ($userId > 0) {
       $where = " WHERE user_id = " . $userId;
    }
    $sql = 'SELECT * FROM products' . $where;
    $result = mysqli_query(getLink(), $sql);
    return $result;
}

function getProductsByIdSet($idSet) {
    $sql = 'SELECT * FROM products WHERE id in (' . $idSet . ')';
    $result = mysqli_query(getLink(), $sql);
    return $result;
}

function getOneProduct($productId) {
    $sql = 'SELECT * FROM products WHERE id = ' . $productId;
    $result = mysqli_query(getLink(), $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function getProductImages($productId) {
    $sql = 'SELECT * FROM products_images WHERE product_id = ' . $productId;
    $result = mysqli_query(getLink(), $sql);
    return $result;
}

function getProductComments($productId) {
    $sql = 'SELECT * FROM products_comments WHERE product_id = ' . $productId;
    $result = mysqli_query(getLink(), $sql);
    return $result;
}

function getOnePicture($imgId) {
    $sql = 'SELECT * FROM products_images WHERE id = ' . $imgId;
    $result = mysqli_query(getLink(), $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}