<?php
function indexAction()
{
    $result = getProducts();

    $productsHtml = renderTmpl('tproducts.php', [
       'result' => $result,
    ]);

    echo render('tgeneral.php', [
        'title' => 'Каталог товаров',
        'h1' => 'Каталог товаров',
        'html' => $productsHtml,
    ]);
}
