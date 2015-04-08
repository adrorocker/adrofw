<?php

namespace Adroframework\View;

use Adroframework\View\ViewAbstract as ViewAbstract;
use Adroframework\View\ViewInterface as ViewInterface;
use Adroframework\View\Loader\ViewLoader;
use Adroframework\Http\Uri;

class View extends ViewAbstract implements ViewInterface
{
    const APP_CONFG_DIRECTORY = 'configs';

    protected $applicationConfig;
    protected $appViewConfigs;
    protected $viewLoader;

    public $layout;

    public function __construct()
    {
        $this->setApplicationConfigFile();
        $this->setAppViewConfigs();
        $this->setLayout();
        $this->viewLoader = new ViewLoader();
        $this->viewLoader->setDirectory($this->getViewDirectory());
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
        return $conf['viewDirectory'];
    }

    public function render($vars = false)
    {
        $this->content = $this->viewLoader->getView($vars);
        $layout = $this->viewLoader->getLayoutRoute($this->getLayout());
        require $layout;
    }

    public function doctype()
    {
        $conf = $this->appViewConfigs;
        if ($conf['doctype'] == 'HTML5') {
            echo "<!doctype html>".PHP_EOL;
        }
        return $this;
    }

    public function setTitle($title = '')
    {
        $this->title = $title;
    }

    public function getViewTitle()
    {
        $default = '-';
        if (isset($this->title)) {
            return $this->title;
        }
        return $default;
    }

    public function addStyle($css, $return = false)
    {
        $uri = new Uri();
        $host = $uri->getServerName();
        $append = $host . 'css/' . $css;

        if($return) {
            return $append;
        } else {
            echo '<link rel="stylesheet" href="' . $append . '">'.PHP_EOL;
        }
        return $this;
    }

    public function addScript($js, $return = false)
    {
        $uri = new Uri();
        $host = $uri->getServerName();
        $append = $host . 'js/' . $js;
        if($return) {
            return $append;
        } else {
            echo ' <script src="'. $append . '"></script>'.PHP_EOL;
        }
        return $this;
    }

    public function addIcon($icon, $return = false)
    {
        $uri = new Uri();
        $host = $uri->getServerName();
        $append = $host . 'img/' . $icon;
        if($return) {
            return $append;
        } else {
            echo '<link href="' . $append . '" rel="icon" type="image/x-icon" />'.PHP_EOL;
        }
        return $this;
    }

    protected function setApplicationConfigFile()
    {
        if (!is_array($this->applicationConfig)) {
            $this->applicationConfig = require APP_PATH.'/'.self::APP_CONFG_DIRECTORY.'/application.config.php';
        }
    }

    protected function setAppViewConfigs()
    {
        $configs = $this->applicationConfig;
        if ($configs['application']['configs']['view_manager']) {
            $vc = $configs['application']['configs']['view_manager'];
            $this->appViewConfigs['doctype'] = $vc['doctype'];
            $this->appViewConfigs['notFoundView'] = $vc['not_found_template'];
            $this->appViewConfigs['exeptionView'] = $vc['exception_template'];
            $this->appViewConfigs['viewDirectory'] = $vc['template_path_stack'][0];
        }
    }
}