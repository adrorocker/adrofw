<?php

namespace Adroframework\Loader;

class LocalizeClass
{
    public $className;

    public function __construct($class = null)
    {
        $this->className = $class;
    }

    public function getClass($name, $mca)
    {
        $classFound = false;
        if(!$mca['module']) {
            $fileNameFormats = array(
                '%sController.php'
            );
            $directories = array(ROOT_PATH . 'application/controllers/');
            foreach ($directories as $directory) {
                foreach ($fileNameFormats as $fileNameFormat) {
                    $path = $directory . sprintf($fileNameFormat, $name);
                    $path = str_replace('\\', '/', $path);
                    if (file_exists($path)) {
                        $classFound = true;
                        require_once $path;
                    }
                }
            }
        }
        if ($classFound) {
            return new $name();
        }
    }
}