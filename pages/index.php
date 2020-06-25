<?php
function indexAction()
{
   echo render('tgeneral.php', [
        'title' => 'Какой-то магазин',
        'h1' => 'Главная страница',
        'html' => "<p class='text'>Главная страница какого-то магазина.</p>",
    ]);
}
