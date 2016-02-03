<?php

class Module
{
    const ROOT_APP_DIRECTORY            = 'application';
    const MODULES_DIRECTORY             = 'modules';
    const MODULE_CONTROLLERS_DIRECTORY  = 'controllers';
    const MODULE_MODELS_DIRECTORY       = 'models';
    const MODULES_VIEWS_DIRECTORY       = 'views';
    const MODULES_FORMS_DIRECTORY       = 'forms';
    const MODULES_HELPERS_DIRECTORY     = 'helpers';

    protected $rootPath;
    protected $moduleName;
    protected $modulePath;

    public function __construct($rootPath)
    {
        if (null === $rootPath) {
            die("Invalid path");
        }
        $this->rootPath = $rootPath;
    }

    public function createModule($name = 'main')
    {
        if (file_exists($this->rootPath.'/'.self::ROOT_APP_DIRECTORY) && 
            file_exists($this->rootPath.'/'.self::ROOT_APP_DIRECTORY.'/'.self::MODULES_DIRECTORY)) {
            if (!file_exists($this->rootPath.'/'.self::ROOT_APP_DIRECTORY.'/'.self::MODULES_DIRECTORY.'/'.$name)) {
                $this->moduleName = $name;
                $this->modulePath = $this->rootPath.'/'.self::ROOT_APP_DIRECTORY.'/'.self::MODULES_DIRECTORY.'/'.$name;
                $this->createModuleDirectories();
            }
        } else {
            die("Application directory or module directory does not exist.");
        }
    }

    protected function createModuleDirectories()
    {
        try {
            if (!file_exists ( $this->modulePath) ) {
                mkdir($this->modulePath);
            }
            if (!file_exists ( $this->modulePath.'/'.self::MODULE_CONTROLLERS_DIRECTORY) ) {
                mkdir($this->modulePath.'/'.self::MODULE_CONTROLLERS_DIRECTORY);
            }
            if (!file_exists ( $this->modulePath.'/'.self::MODULE_MODELS_DIRECTORY) ) {
                mkdir($this->modulePath.'/'.self::MODULE_MODELS_DIRECTORY);
            }
            if (!file_exists ( $this->modulePath.'/'.self::MODULES_VIEWS_DIRECTORY) ) {
                mkdir($this->modulePath.'/'.self::MODULES_VIEWS_DIRECTORY);
            }
            if (!file_exists ( $this->modulePath.'/'.self::MODULES_FORMS_DIRECTORY) ) {
                mkdir($this->modulePath.'/'.self::MODULES_FORMS_DIRECTORY);
            }
            if (!file_exists ( $this->modulePath.'/'.self::MODULES_HELPERS_DIRECTORY) ) {
                mkdir($this->modulePath.'/'.self::MODULES_HELPERS_DIRECTORY);
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}