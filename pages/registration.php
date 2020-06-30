<?php
function indexAction() {
    echo render('tregistration.php', [
        'title' => 'Регистрация на сайте какого-то магазина',
        'h1' => 'Регистрация',
        'msg' => getMSG(),
    ]);
}
