<?php

/**
 * Adroframework CLI Helper 0.1
 *
 * This helps to create an app file structure and modules file strucure
 * into the modules app directory.
 *
 * @author Adro rocker <ajandro.morelos@jarwebdev.com>
 *
 * Option: 
 * --create:=app 
 * --create:=module --name:<module name>
 */


$shortopts = '';
$longopts  = array(
    "create:",     // Valor obligatorio
    "name::",    // Valor opcional
);
$cmdOptions = getopt($shortopts, $longopts);

if (empty($cmdOptions)) {
    echo "Warning: No options supplied!!! \n";
    exit(0);
}
$rootPath = dirname(dirname(dirname(__DIR__)));

if ('app' == $cmdOptions['create']) {
    createApp($rootPath);
}

function createApp($rootPath = null)
{
    if (null === $rootPath) {
        die("Invalid path");
    }
    require_once $rootPath.'/vendor/Adroframework/Bash/App/App.php';
    $app = new App($rootPath);
    $app->createApp();
}

function createModule()
{

}
