<?php
function multiTable($dimension) {
    $result = "<tr><td></td>";
    for ($i = 1; $i <= $dimension; $i++) {
        $result .= "<td>$i</td>";
    }
    $result .= "</tr>";

    for ($i = 1; $i <= $dimension; $i++) {
        $result .= "<tr><td>$i</td>";
        for ($j = 1; $j <= $dimension; $j++) {

            $result .= "<td>" . $i * $j . "</td>";
        }
        $result .= "</tr>";
    }
    return "<table cellpadding='10' border style='border-collapse: collapse;'>$result</table>";
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
    <title>Task 10</title>
</head>
<body>
    <?php
       echo multiTable(10);
    ?>
</body>
</html>