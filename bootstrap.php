<?php

// Shipbeat PHP autoloader
function shipbeatAutoload($class) {
    $classPath = str_replace('_', '/', $class);
    $path = realpath(dirname(__FILE__)) . '/src/' . $classPath . '.php';

    if (file_exists($path)) {
        require($path);
        return true;
    }

    return false;
}

spl_autoload_register('shipbeatAutoload');
