<?php
function evenodd($from, $to) {
    $i = $from;
    $result = '';
    do {
        if ($i === 0) {
          $result .= $i . ' - ноль.<br>';
          $i++;
          continue;
        }

        if ($i % 2 === 0) {
          $result .= $i . ' - четное число.<br>';
        } else {
          $result .= $i . ' - нечетное число.<br>';
        }
        $i++;
    } while ($i <= $to);

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
    <title>Task 2</title>
</head>
<body>
    <?php
       echo evenodd(0, 10);
    ?>
</body>
</html>