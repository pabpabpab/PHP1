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

$summary = '$a = ' . $a . ', $b = ' . $b;
$summary .= '<br>';
$summary .= 'их сумма = ' . addition($a, $b);
$summary .= '<br>';
$summary .= 'их разность = ' . subtraction($a, $b);
$summary .= '<br>';
$summary .= 'их произведение = ' . multiplication($a, $b);
$summary .= '<br>';
$summary .= 'их частное = ' . division($a, $b);
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
    <title>Task 3</title>
</head>
<body>
    <?php
       echo $summary;
    ?>
</body>
</html>