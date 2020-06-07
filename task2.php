<?php
$a = rand(0, 15);
$summary = '';

switch ($a) {
    default:
        $summary = 'Какая-то ошибка в логике программы.';
    case 0:
        $summary .=  ' 0';
    case 1:
        $summary .=  ' 1';
    case 2:
        $summary .=  ' 2';
    case 3:
        $summary .=  ' 3';
    case 4:
        $summary .=  ' 4';
    case 5:
        $summary .=  ' 5';
    case 6:
        $summary .=  ' 6';
    case 7:
        $summary .=  ' 7';
    case 8:
        $summary .=  ' 8';
    case 9:
        $summary .=  ' 9';
    case 10:
        $summary .=  ' 10';
    case 11:
        $summary .=  ' 11';
    case 12:
        $summary .=  ' 12';
    case 13:
        $summary .=  ' 13';
    case 14:
        $summary .=  ' 14';
    case 15:
        $summary .=  ' 15';
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
    <title>Task 2</title>
</head>
<body>
    <?php
       echo $summary;
    ?>
</body>
</html>