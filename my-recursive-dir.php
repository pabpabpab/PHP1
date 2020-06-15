<?php

function myRecursiveDir($dName) {
    $files = [];
    $foldersText = '';
    $scanned = scandir($dName);
    foreach ($scanned as $value) {
        if (!in_array($value, ['.', '..'])) {
            if (is_dir($dName . '/' . $value)) {
                $newName = $dName . '/' . $value;
                $foldersText .= '<b>' . $value;
                if (count(scandir($newName)) > 2) {
                    $foldersText .= ':';
                }
                $foldersText .= '</b><br>';
                $foldersText .= myRecursiveDir($newName);
            } else {
                $files[] = $value;
            }
        }
    }

    $filesText = '';
    if (!empty($files)) {
        $filesText = implode(', ', $files) . '<br>';
    }

    return '<div class="ml30">' . $filesText . $foldersText . '</div>';
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
        .small_img {
            width:100px;
            margin:10px;
        }
        .ml30 {
            margin-left: 30px;
        }
    </style>
    <title>Task 3</title>
</head>
<body>
<?php echo myRecursiveDir(__DIR__ . '/logs'); ?>
</body>
</html>