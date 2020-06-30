<?php
function indexAction() {

    $html = "login: <b>123123@123.ru</b> , password: <b>123123</b> , admin<br>";
    $html .= "login: <b>333@333.ru</b> , password: <b>123456</b><br>";
    $html .= "login: <b>qwerty@qwerty.ru</b> , password: <b>qwerty</b><br>";

    echo render('tgeneral.php', [
        'title' => 'Какой-то магазин',
        'h1' => 'Главная страница',
        'html' => "<p class='text'>{$html}</p>",
    ]);
}
