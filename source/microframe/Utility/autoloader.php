<?php

spl_autoload_register(function ($className) {
    $parts = explode('\\', $className);
    $partso = $parts;
    if (is_array($parts)) {
        $class = array_pop($parts);

        $filename =  BASE_PATH . DIRECTORY_SEPARATOR . strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . DIRECTORY_SEPARATOR . $class . '.php';

        if (file_exists($filename)) {
            require $filename;
        }
    }
});