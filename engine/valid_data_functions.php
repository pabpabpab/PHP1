<?php

function allKeysExist(array $keys, array $stack): bool {
   foreach ($keys as $key) {
       if (!array_key_exists($key, $stack)) {
           return false;
       }
   }
   return true;
}


function stripInjection($input) {
    // return mysqli_real_escape_string(getLink(), htmlspecialchars(strip_tags(trim($input))));
    return mysqli_real_escape_string(getLink(), strip_tags(trim($input)));
}


function getInt($input) {
    if (is_numeric($input)) {
        return (int) $input;
    }
    return 0;
}


function getNumeric($input) {
    if (is_numeric($input)) {
        return $input + 0;
    }
    return 0;
}

function checkFolder($folderName) {
    if (!is_dir($folderName)) {
        if (!mkdir($folderName, 0777)) {
            exit("Не могу создать папку " . $folderName);
        }
    }
}

