<?php

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



function myMultipleUpload($uploadDirPath, $uploadDir, $userFile, $maxUploadSizeMb, $prefix) {

    $imgNumber = count($_FILES[$userFile]['name']);
    $errors = [];
    $correctImages = [];

    for ($i = 0; $i < $imgNumber; $i++) {
        $error = '';

        if ($_FILES[$userFile]['error'][$i] > 0) {
           $error .= "файл " . $i . " - " . getUploadError($_FILES[$userFile]['error'][$i]) . "<br>";
        }

        if ($_FILES[$userFile]['size'][$i] > $maxUploadSizeMb * 1024 * 1024) {
           $error .= "файл " . $i . " - " . "более {$maxUploadSizeMb} мегабайт." . "<br>";
        }

        $fileExtension = getExtension($_FILES[$userFile]['type'][$i]);
        if (empty($fileExtension)) {
           $error .= "файл " . $i . " - " . "недопустимый формат, разрешены: " . implode(", ", getMimeTypes()) . "." . "<br>";
        }

        if (!empty($error)) {
            $errors[] = $error;
            continue;
        }


        $imgName = uniqid($prefix . '_') . "." . $fileExtension;
        $destination = $uploadDirPath . $uploadDir . "/" . $imgName;

        if (!move_uploaded_file($_FILES[$userFile]['tmp_name'][$i], $destination)) {
           $errors[] = "Возможная атака с помощью файловой загрузки!";
        } else {
           $correctImages[] = $imgName;
        }
    }


    return [$correctImages, $errors];
}


