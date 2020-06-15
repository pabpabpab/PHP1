<?php
$regions = [
   'Московская область' => [
      'Москва', 'Зеленоград', 'Клин'
   ],
   'Ленинградская область' => [
      'Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт'
   ],
   'Рязанская область' => [
      'Рязань', 'Шацк', 'Спасск-Рязанский'
   ]
];

/*
$result = '';
foreach ($regions as $region => $cities) {
  $result .= $region . ':<br>';
  $result .= implode(', ', $regions[$region]);
  $result .= '<br>';
}
*/

$result = '';
foreach ($regions as $region => $cities) {
   $result .= $region . ':<br>';
   foreach ($cities as $city) {
       $result .= $city;
       if (next($cities)) $result .= ', ';
   }
   $result .= '<br>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <style>
        body {
          font-size: 1rem;
        }
    </style>
    <title>Task 3</title>
</head>
<body>
    <?php
       echo $result;
    ?>
</body>
</html>