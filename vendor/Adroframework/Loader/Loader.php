<?php

class Loader
{
    const MODULE_MODE    = 'module';
    const MAIN_MODE     = 'main';
    const APP_CONFG_DIRECTORY = 'configs';

    public $class;

    protected $configs;
    protected $directories      = array();
    protected $afwDirectories   = array();
    protected $fileFormats      = array();
    protected $afwFileFormats   = array();
    protected $isAfwClass       = false;

    public function __construct($class = null)
    {
        $this->setConfigs();
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
            if ($this->class === 'I18n' || $this->class === 'HtmlForm') {
                array_push($directories, ROOT_PATH . 'vendor/Adroframework/Lang/');
                array_push($directories, ROOT_PATH . 'vendor/Adroframework/Html/');
            } else {
                $modules = $this->getModules();
                if (in_array($this->getModule(), array_keys($modules))) {
                    $module = $this->getModule();
                    $modulesDirectory = ROOT_PATH . 'application/modules/';
                    if (file_exists($modulesDirectory)) {
                        array_push($directories, ROOT_PATH . 'application/');
                        array_push($directories, ROOT_PATH . 'application/modules/'.$module.'/controllers/');
                        array_push($directories, ROOT_PATH . 'application/modules/'.$module.'/models/');
                        array_push($directories, ROOT_PATH . 'application/modules/'.$module.'/helpers/');
                        array_push($directories, ROOT_PATH . 'application/modules/'.$module.'/forms/');
                    }
                } else {
                    array_push($directories, ROOT_PATH . 'application/');
                    array_push($directories, ROOT_PATH . 'application/helpers/');
                    array_push($directories, ROOT_PATH . 'application/forms/');
                    array_push($directories, ROOT_PATH . 'application/filters/');
                    array_push($directories, ROOT_PATH . 'application/controllers/');
                    array_push($directories, ROOT_PATH . 'application/models/');
                }
            }
            $this->directories = $directories;
        }
    }

    public function getUri()
    {
        $url = urldecode($_SERVER['REQUEST_URI']);
        $url = trim($url, '/');
        return $url;
    }

    public function getServerName()
    {   
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $this->serverName = $protocol.$_SERVER['SERVER_NAME'].'/';
        return $this->serverName;
    }

    public function getModule()
    {
        $moduleControllerAction = $this->getModuleControllerAction();
        return $moduleControllerAction['module'];
    }
    public function getModuleController()
    {
        $moduleControllerAction = $this->getModuleControllerAction();
        return $moduleControllerAction['controller'];
    }
    public function getModuleAction()
    {
        $moduleControllerAction = $this->getModuleControllerAction();
        return $moduleControllerAction['action'];
    }

    public function getModuleModel()
    {
        $model = $this->getModuleController().'Model';
        return $model;
    }

    public function getModuleControllerAction()
    {
        $modules = array_keys($this->configs['application']['modules']);
        $uri = $this->getUri();
        $uri = explode('/', $uri);

        if(!empty($modules) && in_array($uri[0], $modules)) {
            $moduleControllerAction = $this->parse(self::MODULE_MODE, $uri);
        } else {
            $moduleControllerAction = $this->parse(self::MAIN_MODE, $uri);
        }
        return $moduleControllerAction;
    }

    protected function parse($mode, $uri)
    {
        if (self::MAIN_MODE == $mode) {
            $module = null;
            if (isset($uri[0]) && '' != $uri[0]) {
                $controller = ucfirst($uri[0]);
            } else {
                $controller = 'Index';
            }
            if (isset($uri[1])) {
                $action = $uri[1].'Action';
            } else {
                $action = 'indexAction';
            }
        } elseif (self::MODULE_MODE == $mode) {
            if (isset($uri[0]) && '' != $uri[0]) {
                $module = $uri[0];
            } else {
                $module = null;
            }
            if (null == $module) {
                $controller = null;
                $action = null;
            } else {
                if (isset($uri[1])) {
                    $controller = ucfirst($uri[1]);
                } else {
                    $controller = 'Index';
                }
                if (isset($uri[2])) {
                    $action = $uri[2].'Action';
                } else {
                    $action = 'indexAction';
                }
            }
        }
        
        $moduleControllerAction = array(
            'module' => $module,
            'controller' => $controller,
            'action' => $action
        );

        return $moduleControllerAction;
    }

    public function setConfigs()
    {
        if (APPLICATION_ENV == 'development') {
            $this->configs = require APP_PATH.self::APP_CONFG_DIRECTORY.'/development/application.config.php';
            return;
        }
        $this->configs = require APP_PATH.self::APP_CONFG_DIRECTORY.'/application.config.php';
    }

    public function getAllConfigs()
    {               
        if (!isset($this->configs) && !is_array($this->configs)) {
            $this->setConfigs();
        }
        return  $this->configs;
    }

    public function getConfig($key = '')
    {
        $configs = $this->getAllConfigs();
        if (isset($configs['application']['configs'][$key])) {
            return $configs['application']['configs'][$key];
        }
    }

    public function getModules($default = array())
    {
        $configs = $this->getAllConfigs();
        if (isset($configs['application']['modules'])) {
            return $configs['application']['modules'];
        }
        return $default;
    }

    public function getFilters($default = array())
    {
        $configs = $this->getAllConfigs();
        if (isset($configs['application']['filters'])) {
            return $configs['application']['filters'];
        }
        return $default;
    }
}