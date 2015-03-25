<?php

class Loader
{
    public $class;

    protected $directories      = array();
    protected $afwDirectories   = array();
    protected $fileFormats      = array();
    protected $afwFileFormats   = array();
    protected $isAfwClass       = false;

    public function __construct($class = null)
    {
        if (null !== $class) {
            $this->class = $class;
            if (strpos($this->class,'Adroframework') !== false) {
                $this->isAfwClass = true;
                $this->setAfwDirectories();
                $this->setAfwFileFormats();
            } else {
                $this->setDirectories(); 
                $this->setFileFormats();   
            }
        }
    }

    public function LoadClass()
    {
        if ($this->isAfwClass !== false) {
            $directories = $this->afwDirectories;
            $fileNameFormats = $this->afwFileFormats;
        } else {
            $directories = $this->directories;
            $fileNameFormats = $this->fileFormats;
        }
        foreach ($directories as $directory) {
            foreach ($fileNameFormats as $fileNameFormat) {
                $path = $directory . sprintf($fileNameFormat, $this->class);
                $path = str_replace('\\', '/', $path);
                if (file_exists($path)) {
                    require_once $path;
                }
            }
        }
    }

    protected function setAfwDirectories()
    {
        if (empty($this->afwDirectories)) {
            $directories = array(
                ROOT_PATH . 'vendor/'
            );
            $this->afwDirectories = $directories;
        }
    }

    protected function setAfwFileFormats()
    {
        if (empty($this->afwFileFormats)) {
            $fileNameFormats = array(
                '%s.php',
            );
            $this->afwFileFormats = $fileNameFormats;
        }
    }

    protected function setFileFormats()
    {
        if (empty($this->fileFormats)) {
            $fileNameFormats = array(
                '%s.php',
                '%sModel.php',
                '%sController.php'
            );
            $this->fileFormats = $fileNameFormats;
        }
    }

    protected function setDirectories()
    {
        if (empty($this->directories)) {
            $directories = array();
            array_push($directories, ROOT_PATH . 'application/');
            $modulesDirectory = ROOT_PATH . 'application/modules/';
            if (file_exists($modulesDirectory)) {
                $modulesDirectories = scandir($modulesDirectory);
                foreach ($modulesDirectories as $modulesDirectory) {
                    if('.' != $modulesDirectory && '..' != $modulesDirectory) {
                        array_push($directories, ROOT_PATH . 'application/modules/'.$modulesDirectory.'/controllers/');
                        array_push($directories, ROOT_PATH . 'application/modules/'.$modulesDirectory.'/models/');
                        array_push($directories, ROOT_PATH . 'application/modules/'.$modulesDirectory.'/helpers/');
                        array_push($directories, ROOT_PATH . 'application/modules/'.$modulesDirectory.'/forms/');
                    }
                }
            }
            $this->directories = $directories;
        }
    }
}