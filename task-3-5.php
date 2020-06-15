<?php
function spaceToUnderline($str) {
    // return str_replace(' ', '_', $str);
    for($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] === ' ') $str[$i] = '_';
    }
    return $str;
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
    <title>Task 5</title>
</head>
<body>
    <?php
       echo spaceToUnderline('Привет Вася Коля!');
    ?>
</body>
</html>