<?php
$matches = [
  'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
  'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
  'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
  'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ъ' => 'ie', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
];

function doMatch($letter, $matches) {
    if ($matches[$letter]) {
        return $matches[$letter];
    } else {
        return $letter;
    }
}

function rusToLatin($str, $matches) {
    $result = '';
    for ($i = 0; $i < strlen($str); $i++) {
        $letter = mb_substr($str,$i,1);

        if (mb_strtolower($letter) != $letter) {
            $letter = mb_strtolower($letter);
            $result .= mb_strtoupper(doMatch($letter, $matches));
            continue;
        }

        $result .= doMatch($letter, $matches);
    }
    return $result;
}

function spaceToUnderline($str) {
    for($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] === ' ') $str[$i] = '_';
    }
    return $str;
}


function createUrl($str, $matches) {
    return spaceToUnderline(rusToLatin($str, $matches));
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
    <title>Task 9</title>
</head>
<body>
    <?php
       echo createUrl('Бармен украл миллионы и четыре месяца жил как богач', $matches);
    ?>
</body>
</html>