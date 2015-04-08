<?php

namespace Adroframework\Http;

use Adroframework\Module\ModuleHelper;

class Uri
{
    const MODEL_MODE    = 'model';
    const MAIN_MODE     = 'main';

    protected $moduleHelper;

    public function __construct()
    {
        $this->moduleHelper = new ModuleHelper();
    }

    public function getModuleHelper()
    {
        return $this->moduleHelper;
    }

    public function getUri()
    {
        $url = urldecode($_SERVER['REQUEST_URI']);
        $url = trim($url, '/');
        return $url;
    }

    public function getServerName()
    {   
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
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
        $modules = $this->getModuleHelper()->getModuleNames();
        $uri = $this->getUri();
        $uri = explode('/', $uri);

        if(!empty($modules) && in_array($uri[0], $modules)) {
            $moduleControllerAction = $this->parse(self::MODEL_MODE, $uri);
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
        } elseif (self::MODEL_MODE == $mode) {
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
}