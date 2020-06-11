<?php
$regions = [
   'Московская область' => [
      'Москва', 'Зеленоград', 'Клин'
   ],
   'Ленинградская область' => [
      'Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт'
   ],
   'Рязанская область' => [
      'Рязань', 'Шацк', 'Касимов'
   ]
];

function citiesByLetter($regions, $letter) {
    $result = '';
    foreach ($regions as $region => $cities) {
        $result .= $region . ':<br>';
        $citySet = [];
        foreach ($cities as $city) {
            if (mb_substr($city, 0, 1) === $letter) {
                $citySet[] = $city;
            }
        }
        $result .= implode(', ', $citySet);
        $result .= '<br>';
    }
    return $result;
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
    <title>Task 8</title>
</head>
<body>
    <?php
       echo citiesByLetter($regions, 'К');
    ?>
</body>
</html>