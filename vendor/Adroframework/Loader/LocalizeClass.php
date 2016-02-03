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
        } else {
            $fileNameFormats = array(
                '%sController.php'
            );
            $directories = array();
            array_push($directories, ROOT_PATH . 'application/modules/'.$mca['module'].'/controllers/');
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

    public function getValidator($name = null)
    {
        $name = ucfirst($name);
        $className = $name .'Validator';
        $classFound = false;
        $directories = array();
        array_push($directories,ROOT_PATH . 'vendor/Adroframework/Validator/Validators/');
        array_push($directories,ROOT_PATH . 'application/forms/validators/');
        foreach ($directories as $directory) {
            $path = $directory . $className.'.php';
            $path = str_replace('\\', '/', $path);
            if (file_exists($path)) {
                $classFound = true;
                require_once $path;
            }
        }
        if ($classFound) {
            $validator = new $className();
            return new $className();
        }
    }

    public function getFilter($name = null)
    {
        $name = ucfirst($name);
        $className = $name .'Filter';
        $classFound = false;
        $directories = array();
        array_push($directories,ROOT_PATH . 'vendor/Adroframework/Filters/');
        array_push($directories,ROOT_PATH . 'application/filters/');
        foreach ($directories as $directory) {
            $path = $directory . $className.'.php';
            $path = str_replace('\\', '/', $path);
            if (file_exists($path)) {
                $classFound = true;
                require_once $path;
            }
        }
        if ($classFound) {
            $validator = new $className();
            return new $className();
        }
    }
}