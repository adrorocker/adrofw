<?php

namespace Adroframework\View;

use Adroframework\Http\Uri;

abstract class ViewAbstract
{
    public function doctype()
    {
        echo "<!doctype html>".PHP_EOL;
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
        $conf = is_a($this, 'Adroframework\View\Loader\ViewLoader') ? $this->configs['views'] : $this->appViewConfigs['views'];
        $path = ROOT_PATH.'public/themes/'.$conf.'/css/' . $css;
        if (file_exists($path)) {
            $append = $host . 'themes/'.$conf.'/css/' . $css;
        } else {
            $append = $host . 'css/' . $css;
        }
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
        $conf = is_a($this, 'Adroframework\View\Loader\ViewLoader') ? $this->configs['views'] : $this->appViewConfigs['views'];
        $path = ROOT_PATH.'public/themes/'.$conf.'/js/' . $js;
        if (file_exists($path)) {
            $append = $host . 'themes/'.$conf.'/js/' . $js;
        } else {
            $append = $host . 'js/' . $js;
        }
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
        $conf = is_a($this, 'Adroframework\View\Loader\ViewLoader') ? $this->configs['views'] : $this->appViewConfigs['views'];
        $path = ROOT_PATH.'public/themes/'.$conf.'/img/' . $icon;
        if (file_exists($path)) {
            $append = $host . 'themes/'.$conf.'/img/' . $icon;
        } else {
            $append = $host . 'img/' . $icon;
        }
        if($return) {
            return $append;
        } else {
            echo '<link rel="shortcut icon "href="' . $append . '" type="image/x-icon" />'.PHP_EOL;
        }
        return $this;
    }

    public function addImage($img, $attributes = array(), $return = false)
    {
        $uri = new Uri();
        $host = $uri->getServerName();
        $conf = is_a($this, 'Adroframework\View\Loader\ViewLoader') ? $this->configs['views'] : $this->appViewConfigs['views'];
        $path = ROOT_PATH.'public/themes/'.$conf.'/img/' . $img;
        if (file_exists($path)) {
            $img = $host . 'themes/'.$conf.'/img/' . $img;
        } else {
            $img = $host . 'img/' . $img;
        }
        $at = '';
        foreach ($attributes as $attribute => $value) {
            $at .= $attribute.'="'.$value.'" ';
        }
        if($return) {
            return $img;
        } else {
            echo '<img src="'.$img.'" '.$at.'>'.PHP_EOL;
        }
        return $this;
    }

    public static function route(array $route, $return = null)
    {
        $host = Uri::getHost();
        if (isset($route['module'])) {
            if (isset($route['controller'])) {
                if (isset($route['action'])) {
                    if (isset($route['params'])) {
                        $params = '';
                        foreach ($route['params'] as $key => $value) {
                            $params .= $key . '/' . $value . '/';
                        }
                        $url = $host . 
                        $route['module'] . '/' .
                        $route['controller'] . '/' .
                        $route['action'] . '/' . $params;
                    } else {
                        $url = $host . 
                        $route['module'] . '/' .
                        $route['controller'] . '/' .
                        $route['action']. '/'; 
                    }
                } else {
                    $url = $host . 
                    $route['module'] . '/' .
                    $route['controller'] . '/';
                }
            } else {
                $url = $host . 
                $route['module'] . '/';
            }
        } else {
            if (isset($route['controller'])){
                if (isset($route['action'])) {
                    if (isset($route['params'])) {
                        $params = '';
                        foreach ($route['params'] as $key => $value) {
                            $params .= $key . '/' . $value . '/';
                        }
                        $url = $host . 
                        $route['controller'] . '/' .
                        $route['action'] . '/' . $params;
                    } else {
                        $url = $host . 
                        $route['controller'] . '/' .
                        $route['action']. '/';
                    }
                } else {
                    $url = $host . 
                    $route['controller'] . '/';
                }
            } else {
                $url = $host;
            }
        }
        if ($return){
            return $url;
        } else {
            echo $url;
        }
    }
}