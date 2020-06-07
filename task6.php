<?php
function power($val, $pow) {
    if ($pow == 1) {
        return $val;
    } else {
        return $val * power($val, $pow-1);
    }
}
$summary = 'power(2, 3) = ' . power(2, 3);
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
    <title>Task 6</title>
</head>
<body>
    <?php
       echo $summary;
    ?>
</body>
</html>