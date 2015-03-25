<?php

if (file_exists(__DIR__.'/vendor/Adroframework/Loader/Loader.php')) {
    require_once __DIR__.'/vendor/Adroframework/Loader/Loader.php';
    $loader = new Loader();
}

if (!isset($loader) || !$loader) {
    throw new Exception("Loader can't be located", 1);
    die();
}

function autoload($className)
{
    $loader = new Loader($className);
    $loader->loadClass();
}
spl_autoload_register('autoload');
