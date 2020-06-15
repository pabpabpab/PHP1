<?php
$i = 0;
$result = '';
while ($i <= 100) {
  if ($i % 3 === 0) {
      $result .= $i . ' ';
  }
  $i++;
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
       echo $result;
    ?>
</body>
</html>