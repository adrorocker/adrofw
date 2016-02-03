<?php

namespace Adroframework\Bootstrap;

use Adroframework\Exception\AdroException;
use Adroframework\Controller\Error;

abstract class BootstrapAbstract
{
    public $uri;

    protected $classLoader;

    protected $configLoader;

    /**
     * Application config file
     */
    protected $acf;

    public function __construct()
    {
        $this->uri = new Uri();
        $this->classLoader = new LocalizeClass();
        $this->configLoader = new Config();
    }

    public function runFilters()
    {
        $filters = $this->configLoader->getFilters();
        foreach ($filters as $filter) {
            $filter = $this->classLoader->getFilter($filter);
            $filter->run();
        }
    }

    public function route()
    {
        $modules = $this->configLoader->getModules();
        $data = $this->uri->getModuleControllerAction();
        $this->dispatch($modules, $data);
    }

    protected function dispatch(array $modules, $data)
    {
        if (in_array($this->uri->getModule(), array_keys($modules))) {
            $this->dispatchModule($data);
        } else {
            $this->dispatchMain($data);
        }
    }

    public function dispatchMain($data = array())
    {
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
        } else {
            try {
                $e = new AdroException("Action : ".$data['controller'].", dont exist");
                $e->setLine(15)->setType('404');
                throw $e;
            } catch (AdroException $e) {
                $err = new Error($e);
                $err->indexAction();
            }
        }
    }

    public function dispatchModule($data = array())
    {
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
        } else {
            try {
                $e = new AdroException("Action : ".$data['controller'].", dont exist");
                $e->setLine(15)->setType('404');
                throw $e;
            } catch (AdroException $e) {
                $err = new Error($e);
                $err->indexAction();
            }
        }

    }

    public function afterDispatch()
    {
    }

    public function actionExist($object, $method)
    {
        if (method_exists($object, $method)) {
            return true;
        } else {
            return false;
        }
    }
}
