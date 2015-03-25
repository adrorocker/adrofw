<?php

namespace Adroframework\Http;

class Uri
{
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
        $url = urldecode($_SERVER['REQUEST_URI']);
        $url = trim($url, '/');
        $url = explode('/', $url);
        if (isset($url[0]) && '' != $url[0]) {
            $module = $url[0];
        } elseif (isset($url[0]) && '' == $url[0]) {
            $module = 'main';
        } else {
            $module = null;
        }
        if (isset($url[1])) {
            $controller = ucfirst($url[1]);
        } else {
            $controller = 'Index';
        }
        if (isset($url[2])) {
            $action = $url[2];
        } else {
            $action = null;
        }
        $moduleControllerAction = array(
            'module' => $module,
            'controller' => ucfirst($controller),
            'action' => $action.'Action'
        );
        return $moduleControllerAction;
    }
}