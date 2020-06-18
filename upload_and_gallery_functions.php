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
        $imgName = uniqid('i') . "." . $fileExtension;
        $destination = $uploadDir . "/" . $imgName;
        if (!move_uploaded_file($_FILES['userFile']['tmp_name'], $destination)) {
            $errors[] = "Возможная атака с помощью файловой загрузки!";
        } else {
            $imgFolder = (int) $uploadDir;
            $imgWeight = $_FILES[$userFile]['size'];

            GLOBAL $dbLink;
            $sql = "INSERT INTO
            gallery
                (img_folder, name_of_small_img, name_of_big_img, weight_of_small_img, weight_of_big_img)
            VALUES
                ($imgFolder, '$imgName', '$imgName', $imgWeight, $imgWeight)";

            mysqli_query($dbLink, $sql);
            // mysqli_query($dbLink, $sql) or die(mysqli_error($dbLink));
        }
    }

    return $errors;
}



function readGalleryFromDatabase($dirname, $scriptName) {
    GLOBAL $dbLink;
    $sql = 'SELECT * FROM gallery ORDER BY number_of_viewings DESC';
    $result = mysqli_query($dbLink, $sql);

    $picturess = [];
    while($row = mysqli_fetch_assoc($result)) {
       $pictures[] = "<a href='{$scriptName}?show_big_img=1&img_id={$row['id']}' target='_blank'><img src='./{$dirname}/{$row['name_of_small_img']}' class='small_img'></a>";

    }
    return implode('', $pictures);
}

?>

