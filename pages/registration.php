<?php
function indexAction()
{
    $error = '';
    if (!empty($_GET['error'])) {
    	$error = $_GET['error'];
    }

    echo render('tregistration.php', [
        'title' => 'Регистрация на сайте какого-то магазина',
        'h1' => 'Регистрация',
        'error' => $error,
    ]);
}
