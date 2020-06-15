<?php

$uploadDir = './gallery';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777)) {
        exit('Не могу создать папку галлереи.');
    }
}

function getUploadError($key) {
    $uploadErrors = [
        0 => 'Ошибок не возникло, файл был успешно загружен на сервер. ',
        1 => 'Размер принятого файла больше разрешенного php.ini.',
        2 => 'Размер загружаемого файла больше разрешенного MAX_FILE_SIZE в HTML-форме.',
        3 => 'Загружаемый файл был получен только частично.',
        4 => 'Файл не был загружен.',
        6 => 'Отсутствует временная папка.',
        7 => 'Не удалось записать файл на диск',
        8 => 'Внутренняя ошибка php при upload файла. '
    ];
    if (!(bool)$uploadErrors[$key]) {
        return 'Неизвестная ошибка при upload файла.';
    }
    return $uploadErrors[$key];
}

function getMimeTypes() {
    return [
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
        'image/gif' => 'gif',
        'image/bmp' => 'bmp',
        'image/webp' => 'webp'
    ];
}

function getExtension($key) {
    return getMimeTypes()[$key];
}

function myUpload($uploadDir, $userFile, $maxUploadSizeMb) {
    $errors = [];

    if ($_FILES['files']['error'] > 0) {
        $errors[] = getUploadError($_FILES['files']['error']);
    }

    if ($_FILES[$userFile]['size'] > $maxUploadSizeMb * 1024 * 1024) {
        $errors[] = "Ваш файл более {$maxUploadSizeMb} мегабайт.";
    }

    $fileExtension = getExtension($_FILES[$userFile]['type']);
    if (empty($fileExtension)) {
        $errors[] = "Недопустимый формат, разрешены: " . implode(", ", getMimeTypes()) . ".";
    }

    if (empty($errors)) {
        $destination = $uploadDir . "/" . uniqid('i') . "." . $fileExtension;
        if (!move_uploaded_file($_FILES['userFile']['tmp_name'], $destination)) {
            $errors[] = "Возможная атака с помощью файловой загрузки!";
        }
    }

    return $errors;
}

function is_image($file) {
    if (!is_file($file)) {
        return false;
    }
    $allowed = ['gif' => 1, 'jpg' => 2, 'png' => 3, 'bmp' => 6];
    $imageType = getimagesize($file)[2];
    if (in_array($imageType, $allowed)) {
        return true;
    }
    return false;
}


if (!empty($_FILES)) {
    $errors = myUpload($uploadDir, 'userFile', 10);
    $errorsText = implode("<br>", $errors);
}


function readGallery($dirname) {
    $files = [];
    $scanned = scandir($dirname);
    foreach ($scanned as $value) {
        $file = "{$dirname}/{$value}";
        if (is_image($file)) {
            $files[] = "<a href='{$file}' target='_blank'><img src='{$file}' class='small_img'></a>";
        }
    }
    return implode('', $files);
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
    </style>
    <title>Task 1</title>
</head>
<body>

<div style="align:center;margin: 30px 0;">
<?php echo $errorsText; ?>
</div>

<form enctype="multipart/form-data" action="upload-and-gallery.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo 10 * 1024 * 1024; ?>" />
    Отправить этот файл: <input name="userFile" type="file" />
    <input type="submit" value="Отправить файл" />
</form>

<div style="display:flex;align-items:center;margin:30px 0;">
    <?php echo readGallery($uploadDir); ?>
</div>

</body>
</html>