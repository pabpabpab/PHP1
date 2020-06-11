<?php
$menu = [
  'Главная' => null,
  'Новости' => [
      'Новости о спорте' => null,
      'Новости о политике' => [
          'Сирия' => [
              'Алеппо' => null,
              'Идлиб' => [
                  'Россия' => null,
                  'Турция' => null
              ],
              'Дамаск' => null
          ],
          'Ливия' => [
              'ПНС' => null,
              'ЛНА' => null
          ],
          'Гонконг' => null
      ],
      'Новости о мире' => null
  ],
  'Контакты' => null,
  'Справка' => null,
];


function submenu($submenu) {
    $tmp = '';
    foreach ($submenu as $item => $value) {
        if (!$value) {
           $tmp .= "<a class='item'>{$item}</a>";
           continue;
        }
        $tmp .= "<a class='item'>{$item}</a>" . submenu($value);
    }
    return "<div class='ml70'>" . $tmp . "</div>";
}


function menu($menu) {
    $menuHtml = '';
    foreach ($menu as $item => $value) {
        if (!$value) {
            $menuHtml .= "<div><a><span>{$item}</span></a></div>";
            continue;
        }
        $menuHtml .= "<div><a><span>{$item}</span></a>" . submenu($value) . "</div>";
    }
    return $menuHtml;
}


$menuHtml = menu($menu);


$content = mb_convert_encoding(file_get_contents('template.html'), "UTF-8", "ISO-8859-5");
echo str_replace('{{MENU}}', $menuHtml, $content);
?>




