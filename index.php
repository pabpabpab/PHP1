<?php
  $lessonNumber = 1;
  define('SUBJECT', 'Lesson');
  $title = SUBJECT . ' ' . $lessonNumber;
  $currentYear = date('Y');
  $h1 = '<h1>' . $title . ' year ' . $currentYear . '</h1>';
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
    <title><?php echo $title; ?></title>
</head>
<body>
    <?php

      echo $h1;
      echo '<b>Task 2</b><br><br>';

      $precise1 = 1.5;
      $precise2 = 1.5e4;
      $precise3 = 6E-8;
      echo "$precise1 | $precise2 | $precise3 <br><br>";


      $a = 1;
      echo "$a <br>";
      echo '$a';
      echo '<br><br>';

      $a = 10;
      $b = (boolean) $b;
      echo $b;
      echo '<br>';
      $a = (boolean) $a;
      echo $a;
      echo '<br><br>';

      $a = 'Hello, ';
      $b = 'world';
      $c = $a . $b;
      echo $c;
      echo '<br><br>';


      $a = 4;
      $b = 5;
      echo $a + $b . '<br>';
      echo $a * $b . '<br>';
      echo $a - $b . '<br>';
      echo $a / $b . '<br>';
      echo $a % $b . '<br>';
      echo $a ** $b . '<br><br>';


      $a = 4;
      $b = 5;
      $a += $b;
      echo "a = " . $a . "<br>";
      $a = 0;
      echo $a++ . '<br>';
      echo ++$a . '<br>';
      echo $a-- . '<br>';
      echo --$a . '<br><br>';


      $a = 4;
      $b = 5;
      var_dump($a == $b);
      echo '<br>';
      var_dump($a === $b);
      echo '<br>';
      var_dump($a > $b);
      echo '<br>';
      var_dump($a < $b);
      echo '<br>';
      var_dump($a <> $b);
      echo '<br>';
      var_dump($a != $b);
      echo '<br>';
      var_dump($a !== $b);
      echo '<br>';
      var_dump($a <= $b);
      echo '<br>';
      var_dump($a >= $b);
      echo '<br><br>';
      echo '<br><br>';


      echo '<b>Task 3</b><br><br>';

      $a = 5;
      $b = '05';
      var_dump($a == $b);         // true т.к. динамическая типизация делает из $b число 5
      echo '<br>';
      var_dump((int)'012345');     // 12345 т.к. принудительное изменение типа к integer
      echo '<br>';
      var_dump((float)123.0 === (int)123.0); // false потому типы данных разные
      echo '<br>';
      var_dump((int)0 === (int)'hello, world'); // true потому что типы одинаковые и строка из букв
                                                // после принудительного приведения типа такой строки к int это 0
      echo '<br><br>';


      echo '<b>Task 5</b><br><br>';

      $a = 1;
      $b = 2;
      $b = (int)(boolean) $a = $b;

      echo '$a = ' . $a . '<br>';
      echo '$b = ' . $b . '<br>';
      var_dump($b);
      echo '<br><br>';

    ?>
</body>
</html>