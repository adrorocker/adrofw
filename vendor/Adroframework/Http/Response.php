<?php

namespace Adroframework\Http;

class Response
{
    public static function json($json = array())
    {
        header('Content-Type: application/json');
        echo json_encode($json);
        die;
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
    public static function route($route = array())
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
        return $url;
    }
}