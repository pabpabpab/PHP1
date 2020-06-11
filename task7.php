<?php
function mytime() {
    $hours = (int) date('G');
    $minutes = (int) date('i');
    $restHours = $hours % 10;
    $restMinutes =  $minutes % 10;

    $textHours = 'часов';
    if ($hours < 5 || $hours > 20) {
        switch ($restHours) {
           case 1:
               $textHours = 'час';
               break;
           case 2:
           case 3:
           case 4:
               $textHours = 'часа';
               break;
       }
    }

    $textMinutes = 'минут';
    if ($minutes < 5 || $minutes > 20) {
        switch ($restMinutes) {
           case 1:
               $textMinutes = 'минута';
               break;
           case 2:
           case 3:
           case 4:
               $textMinutes = 'минуты';
               break;
            default:
               $textMinutes = 'минут';
       }
    }

    return $hours . ' ' . $textHours . ' ' . $minutes . ' ' . $textMinutes;
}
$summary = 'Сейчас ' . mytime();
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
    <title>Task 7</title>
</head>
<body>
    <?php
       echo $summary;
    ?>
</body>
</html>