<?php
$a = rand(-10, 10);
$b = rand(-10, 10);
$resultNote = '';
$resultValue = null;

if ($a >= 0 && $b >= 0) {
    $resultNote = '$a = ' . $a . ', $b = ' . $b . ', их разность = ';
    $resultValue = $a - $b;
} else if ($a < 0 && $b < 0) {
    $resultNote = '$a = ' . $a . ', $b = ' . $b . ', их произведение = ';
    $resultValue = $a * $b;
} else if (($a >= 0 && $b < 0) || ($a < 0 && $b >= 0)) {
    $resultNote = '$a = ' . $a . ', $b = ' . $b . ', их сумма = ';
    $resultValue = $a + $b;
}

$summary = 'Не выполнилось ни одно условие.';
if ($resultValue) {
    $summary = $resultNote . $resultValue;
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
    <title>Task 1</title>
</head>
<body>
    <?php
       echo $summary;
    ?>
</body>
</html>