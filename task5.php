<?php
$currentYear = date('Y');
$summary = $currentYear . '  год';
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
    <title>Task 5</title>
</head>
<body>
    <?php
       echo $summary;
    ?>
</body>
</html>