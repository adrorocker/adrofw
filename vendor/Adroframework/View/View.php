<?php

namespace Adroframework\View;

use Adroframework\View\ViewAbstract as ViewAbstract;
use Adroframework\View\ViewInterface as ViewInterface;
use Adroframework\View\Loader\ViewLoader;
use Adroframework\View\ThemeManager\ThemeManager as ThemeManager;
use Adroframework\Http\Uri;
use Adroframework\Config\Config as Config;
use Adroframework\Exception\AdroException;

class View extends ViewAbstract implements ViewInterface
{

    protected $applicationConfig;
    protected $appViewConfigs;
    protected $viewLoader;
    protected $configLoader;
    protected $uri;

    public $layout;

    public function __construct()
    {
        $this->configLoader = new Config();
        $this->uri = new Uri();
        $this->setApplicationConfigFile();
        $this->setAppViewConfigs();
        $this->setLayout();
        $this->viewLoader = new ViewLoader($this->appViewConfigs, $this->uri->getModuleControllerAction());
    }

    public function setLayout($layout = false)
    {
        if (false == $layout) {
            $this->layout = 'layout';
        } else {
            $this->layout = $layout;
        }
    }

    public function setVariable($name = null ,$var = null)
    {
        if ($name)
            $this->{$name} = $var;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function getViewDirectory()
    {
        $conf = $this->appViewConfigs;
        return $conf['views'];
    }

    public function render($vars = false)
    {
        $this->content = $this->viewLoader->getView($vars);
        $layout = $this->viewLoader->getLayoutRoute($this->getLayout());
        try {
            if (file_exists($layout)) {
                require $layout;
            } else {
                throw new AdroException("The layout $layout don't exist", 1);
            }
        } catch (AdroException $e) {
            echo $e->getMessage();   
        }
    }

    public function renderPartial($view , $vars = false, $return = false)
    {
        $partial = $this->viewLoader->getPartialView($view, $vars);
        if ($return) {
            return $partial;
        }
        echo $partial;
    }

    public function renderError($vars = false)
    {
        $this->content = $this->viewLoader->getErrorView($vars);
        $layout = $this->viewLoader->getLayoutRoute($this->getLayout());
        require $layout;
    }

    protected function setApplicationConfigFile()
    {
        $this->applicationConfig = $this->configLoader->getAllConfigs();
    }

    protected function setAppViewConfigs()
    {
        $configs = $this->applicationConfig;
        $mca = $this->uri->getModuleControllerAction();
        $tm = new ThemeManager($configs, $mca);
        $this->appViewConfigs = $tm->getTheme();
    }

    protected function getAppViewConfigs()
    {
        if (isset($this->appViewConfigs) && is_array($this->appViewConfigs)) {
            return $this->appViewConfigs;
        }
        return null;
    }
}