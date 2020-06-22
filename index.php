<?php
require_once __DIR__ . '/engine/lib.php';

$routes = include __DIR__ . '/config/routes.php';
$page = getPage($routes);

ob_start();
    include __DIR__ . '/pages/' . $page;
$content = ob_get_clean();

$html = file_get_contents(__DIR__ . '/tmpl/main.html');

echo str_replace(
    ['{{TITLE}}', '{{CONTENT}}'],
    [$title, $content],
    $html
);
