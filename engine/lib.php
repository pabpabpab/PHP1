<?php

function getPage(array $routes) {
    $pageNumber = 1;
    if (!empty($_GET['page'])) {
        $pageNumber = (int)$_GET['page'];
    }
    if (empty($routes[$pageNumber])) {
        $pageNumber = 1;
    }
    return $routes[$pageNumber];
}


function allKeysExist(array $keys, array $stack): bool {
   foreach ($keys as $key) {
       if (!array_key_exists($key, $stack)) {
           return false;
       }
   }
   return true;
}


function stripInjection($input) {
    $input = (string)htmlspecialchars(strip_tags($input));
    //return mysqli_real_escape_string($dbLink, $input);
    return $input;
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



function getId($key = 'id') {
    if (!empty($_GET[$key])) {
        return (int) $_GET[$key];
    }
    return 0;
}

?>