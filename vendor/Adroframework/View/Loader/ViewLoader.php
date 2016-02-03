<?php

namespace Adroframework\View\Loader;

use Adroframework\Http\Uri;
use Adroframework\Exception\AdroException;
use Adroframework\View\View;

class ViewLoader extends View
{
    public $uri;
    public $directory;

    public function __construct($configs,$mca)
    {
        $this->uri = new Uri();
        $this->configs = $configs;
        $this->setDirectory($this->configs['views'],$mca);
    }

    public function setDirectory($directory, $mca)
    {
        if ($mca['module']) {
            $this->directory = APP_PATH.'modules/'.$mca['module'].'/views/'.$directory;
            return;
        }
        $this->directory = APP_PATH.'views/'.$directory;
    }

    public function getView($vars = false)
    {
        if ($vars) {
            extract($vars, EXTR_PREFIX_SAME, "view");
        }

        $mca = $this->uri->getModuleControllerAction();
        $controller = strtolower($mca['controller']);
        $action = str_replace('Action','',$mca['action']);
        $path = $this->directory.'/'.$controller.'/'.$action.'.phtml';
        if (file_exists($path)) {
            ob_start();
            include($path);
            $page = ob_get_contents();
            ob_end_clean();
            return $page;
        }
    }

    public function getPartialView($view, $vars = fasle)
    {
        if ($vars) {
            extract($vars, EXTR_PREFIX_SAME, "view");
        }
        $path = $this->directory.'/'.$view.'.phtml';
        if (file_exists($path)) {
            ob_start();
            include($path);
            $page = ob_get_contents();
            ob_end_clean();
            return $page;
        }
    }

    public function getErrorView($vars = false)
    {
        if ($vars) {
            extract($vars, EXTR_PREFIX_SAME, "view");
        }

        if (isset($vars['e']) && is_a($vars['e'], 'Adroframework\Exception\AdroException')) {
            $path = $this->directory.'/error/'.$this->configs['exception_template'].'.phtml';
            if ($e->getType() == '404') {
                $path = $this->directory.'/error/'.$this->configs['not_found_template'].'.phtml';
            }
            if (file_exists($path)) {
                ob_start();
                include($path);
                $page = ob_get_contents();
                ob_end_clean();
                return $page;
            }
        }
    }

    public function getLayoutRoute($layout)
    {
        return $this->directory.'/layouts/'.$layout.'.phtml';
    }

}