<?php

namespace Adroframework\Http;

use Adroframework\Module\ModuleHelper;
use Adroframework\Http\Uri;

class Request
{
    const MODULE    = 'module';
    const MAIN     = 'main';

    protected $moduleHelper;
    protected $_get;
    protected $_post;

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

    public function goBack()
    {
        $url = '/';
        if(isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        }
        header('Location: '.$url);
    }

    public function getIsModuleOrMain()
    {
        $modules = $this->getModuleHelper()->getModuleNames();
        $uri = $this->getUri();
        $uri = explode('/', $uri);

        if(!empty($modules) && in_array($uri[0], $modules)) {
            return self::MODULE;
        } else {
            return self::MAIN;
        }
    }

    public function getParam($param, $default = null)
    {
        $params = $this->getParams();
        if (isset($params[$param]) && is_array($params[$param])) {
            $fileParams = $this->getFileParam($param);
            $params[$param] = array_merge($fileParams, $params[$param]);
        }
        if (array_key_exists($param, $params)) {
            return $params[$param];
        }
        return $default;
    }

    public function getFileParam($param, $default = array())
    {
        $params = $_FILES;
        if (array_key_exists($param, $params)) {
            $name = array_keys($params[$param]['name']);
            $name = $name[0];
            $fileParam = array($name => $params[$param]);
            return $fileParam;
        }
        return $default;
    }
    
    public function getParams()
    {
        $this->_get = is_array($_GET) ? $_GET : [];
        $this->_post = is_array($_POST) ? $_POST : [];
        $params = array();
        $isModule = $this->getIsModuleOrMain();
        if(self::MODULE === $isModule && empty($this->_get)) {
            $url = urldecode($_SERVER['REQUEST_URI']);
            $url = trim($url, '/');
            $url = explode('/', $url);
            $total = count($url);
            for ($i = 0; $i < $total; $i++) {
                if (2 <= $i && $i <= ($total-2)) {
                    $params[$url[$i+1]]  = $url[$i+2];
                }
                $i++;
            }
        } elseif (empty($this->_get)) {
            $url = urldecode($_SERVER['REQUEST_URI']);
            if (false !== strpos($url, "?")) {
                $url = substr($url, 0, strpos($url, "?"));
            }
            $url = trim($url, '/');
            $url = explode('/', $url);
            $total = count($url);
            for ($i = 0; $i < $total; $i++) {
                if (2 <= $i) {
                    $params[$url[$i]]  = $url[$i+1];
                }
                $i++;
            }
        }
        $params = array_merge($this->_get, $this->_post, $params);
        return $params; 
    }

    public static function getServerName()
    {   
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $serverName = $protocol.$_SERVER['SERVER_NAME'].'/';
        return $serverName;
    }

    public static function redirect($route = array())
    {
        $host = self::getServerName();
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
                        $route['action']; 
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
                        $route['action'];
                    }
                } else {
                    $url = $host . 
                    $route['controller'] . '/';
                }
            } else {
                $url = $host;
            }
        }
        header('Location: ' . $url);
    }
}