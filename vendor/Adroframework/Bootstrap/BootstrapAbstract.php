<?php

namespace Adroframework\Bootstrap;

abstract class BootstrapAbstract
{
    const APP_CONFG_DIRECTORY = 'configs';
    /**
     * Application config file
     */
    protected $acf;

    public function getAclInstance()
    {
    }

    public function setAclInstance()
    {
    }

    public function checkAclAccess()
    {   
    }

    public function route()
    {
        $modules = $this->getModules();
        if(in_array($this->uri->getModule(), $modules)) {
            if (class_exists($this->uri->getModuleController())) {
                die("in2");
                if($this->_urlHelper->methodExist($this->_urlHelper->getModuleController(), $this->_urlHelper->getModuleAction())) {
                    $this->_auth->roleRedirect();
                    $controller = $this->_urlHelper->getModuleController();
                    $controller = new $controller();
                } else {
                    $error = new \Error(2);
                    $error->indexAction();
                    die("method not found");
                }   
            } else {
                //$error = new \Error(1);
                //$error->indexAction();
                die("class not found");
            }

            $modelName = $this->_urlHelper->getModuleModel();
            if (class_exists($modelName)) {
                $controller->model = new $modelName();
            }

            if ('Action' === $this->_urlHelper->getModuleAction()) {
                $this->_auth->roleRedirect();
                $controller->indexAction();
            } else {
                if (method_exists($controller, $this->_urlHelper->getModuleAction())) {
                    $this->_auth->roleRedirect();
                    $action = $this->_urlHelper->getModuleAction();
                    $controller->$action();
                } else {
                    $error = new \Error(2);
                    $error->indexAction();
                    die();
                }
            }
            die();
        }
    }

    public function getModules()
    {
        $modulesConfig = $this->getApplicationConfigFile();
        $modulesKeys = array_keys($modulesConfig['application']['modules']);
        return $modulesKeys;
    }

    public function actionExist($object, $method)
    {
        $class = new $object();
        if ('Action' === $method) {
            $method = 'indexAction';
        }
        if (method_exists($class, $method)) {
            return true;
        } else {
            return false;
        }
    }

    public function getApplicationConfigFile()
    {
        $this->acf = require APP_PATH.'/'.self::APP_CONFG_DIRECTORY.'/application.config.php';
        return $this->acf;
    }

}
