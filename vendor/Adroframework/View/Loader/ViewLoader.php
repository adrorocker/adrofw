<?php

namespace Adroframework\View\Loader;

use Adroframework\Http\Uri;
use Adroframework\Exception\AdroException;

class ViewLoader
{
    public $uri;
    public $directory;

    public function __construct()
    {
        $this->uri = new Uri();
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    public function getView($vars = false)
    {
        if ($vars) {
            extract($vars, EXTR_PREFIX_SAME, "view");
        }

        if (isset($vars['e']) && is_a($vars['e'], 'Adroframework\Exception\AdroException')) {
            $path = $this->directory.'/error/index.phtml';
            if ($e->getType() == '404') {
                $path = $this->directory.'/error/404.phtml';
            }
            if (file_exists($path)) {
                ob_start();
                include($path);
                $page = ob_get_contents();
                ob_end_clean();
                return $page;
            }
        }
        $mca = $this->uri->getModuleControllerAction();
        if (!$mca['module']) {
            $controller = strtolower($mca['controller']);
            $action = str_replace('action','',strtolower($mca['action']));
            $path = $this->directory.'/'.$controller.'/'.$action.'.phtml';
            if (file_exists($path)) {
                ob_start();
                include($path);
                $page = ob_get_contents();
                ob_end_clean();
                return $page;
            }
            //TODO: exception
        }
    }

    public function getLayoutRoute($layout)
    {
        return $this->directory.'/layouts/'.$layout.'.phtml';
    }

}