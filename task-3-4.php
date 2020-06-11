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
    <title>Task 4</title>
</head>
<body>
    <?php
       echo rusToLatin('Привет Вася Коля!', $matches);
    ?>
</body>
</html>