<?php

namespace Adroframework\Bootstrap;

use Adroframework\Exception\AdroException;
use Adroframework\controller\Error;

abstract class BootstrapAbstract
{
    const APP_CONFG_DIRECTORY = 'configs';

    public $uri;

    protected $classLoader;

    /**
     * Application config file
     */
    protected $acf;

    public function __construct()
    {
        $this->uri = new Uri();
        $this->classLoader = new LocalizeClass();
    }

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
        $data = $this->uri->getModuleControllerAction();
        $this->dispatch($modules, $data);
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
        } else {

        }
    }

    protected function dispatch(array $modules, $data)
    {
        if (in_array($this->uri->getModule(), $modules)) {
            die('module');
        } else {
            $c = $this->uri->getModuleController();
            $controller = $this->classLoader->getClass($c, $data);
            if (is_object($controller) && $data['action']) {
                $e = $this->actionExist($controller,$data['action']);
                if ($e) {
                    $controller->{$data['action']}();
                } else {
                    try {
                        $e = new AdroException("Action : ".$data['action'].", dont exist");
                        $e->setLine(3)->setType('404');
                        throw $e;
                    } catch (AdroException $e) {
                        $err = new Error($e);
                        $err->indexAction();
                    }
                }
            }
        }
    }

    public function dispatchMain()
    {
    }

    public function dispatchModule()
    {
    }

    public function getModules()
    {
        $modulesConfig = $this->getApplicationConfigFile();
        $modulesKeys = array_keys($modulesConfig['application']['modules']);
        return $modulesKeys;
    }

    public function actionExist($object, $method)
    {
        if (method_exists($object, $method)) {
            return true;
        } else {
            return false;
        }
    }

    public function getApplicationConfigFile()
    {
        if (!is_array($this->acf)) {
            $this->acf = require APP_PATH.'/'.self::APP_CONFG_DIRECTORY.'/application.config.php';
        }
        return $this->acf;
    }

}
