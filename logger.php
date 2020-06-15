<?php

$logfile = '/log.txt';
$logDirName = './logs';
if (!is_dir($logDirName)) {
    if (!mkdir($logDirName, 0777)) {
        exit('Не могу создать папку для лог-файлов.');
    }
}
if (!is_file("{$logDirName}/{$logfile}")) {
    file_put_contents("{$logDirName}/{$logfile}", '');
}



function readLog($logDirName, $logfile) {
    return str_replace("\r\n", "<br>", file_get_contents("{$logDirName}/{$logfile}"));
}

function countRows($logDirName, $logfile) {
    return count(explode("\r\n", file_get_contents("{$logDirName}/{$logfile}")));
}

function calcNextLogId($logDirName) {
    $pattern = '/^log\d+\.txt$/';
    $scanned = scandir($logDirName);
    $logFiles = preg_grep($pattern, $scanned);
    $idSet = str_replace(['log', '.txt'], ['', ''], $logFiles);
    if (empty($idSet)) {
        return 1;
    }
    return max($idSet) + 1;
}

function logger($logDirName, $logfile) {
    if (countRows($logDirName, $logfile) > 10) {
        $nextLogFile = 'log' . calcNextLogId($logDirName) . '.txt';
        rename("{$logDirName}/{$logfile}", "{$logDirName}/{$nextLogFile}");
    }
    $record = date("d-m-Y H:i:s") . "\r\n";
    file_put_contents("{$logDirName}/{$logfile}", $record, FILE_APPEND);
}

logger($logDirName, $logfile);
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
    </style>
    <title>Task 2</title>
</head>
<body>
<?php echo readLog($logDirName, $logfile); ?>
</body>
</html>