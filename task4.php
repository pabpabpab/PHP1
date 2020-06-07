<?php
$a = rand(1, 10);
$b = rand(1, 10);

function addition($a, $b) {
   return $a + $b;
}
function subtraction($a, $b) {
   return $a - $b;
}
function multiplication($a, $b) {
   return $a * $b;
}
function division($a, $b) {
   return round($a / $b, 2);
}
function mathOperation($arg1, $arg2, $operation) {
    switch ($operation) {
       case 'addition':
           return addition($arg1, $arg2);
           break;
       case 'subtraction':
           return subtraction($arg1, $arg2);
           break;
       case 'multiplication':
           return multiplication($arg1, $arg2);
           break;
       case 'division':
           return division($arg1, $arg2);
           break;
       default:
           return 'неизвестная операция';
    }
}

$summary = '$a = ' . $a . ', $b = ' . $b;
$summary .= '<br>';
$summary .= 'их сумма = ' . mathOperation($a, $b, 'addition');
$summary .= '<br>';
$summary .= 'их разность = ' . mathOperation($a, $b, 'subtraction');
$summary .= '<br>';
$summary .= 'их произведение = ' . mathOperation($a, $b, 'multiplication');
$summary .= '<br>';
$summary .= 'их частное = ' . mathOperation($a, $b, 'division');
$summary .= '<br>';
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
       echo $summary;
    ?>
</body>
</html>