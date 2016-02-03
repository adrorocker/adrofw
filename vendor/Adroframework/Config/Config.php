<?php

namespace Adroframework\Config;

class Config
{
    const APP_CONFG_DIRECTORY = 'configs';

    protected $configs;

    public function __construct()
    {
        $this->init();
        $this->setConfigs();
    }
    /**
     * Initialize session.
     */
    public function init()
    {
        @session_start();
    }

    public function setConfigs()
    {
        if (APPLICATION_ENV == 'development') {
            $this->configs = require APP_PATH.'/'.self::APP_CONFG_DIRECTORY.'/development/application.config.php';
            return $this;
        }
        $this->configs = require APP_PATH.'/'.self::APP_CONFG_DIRECTORY.'/application.config.php';
        return $this;
    }

    public function getAllConfigs()
    {               
        if (!isset($this->configs) && !is_array($this->configs)) {
            $this->setConfigs();
        }
        return  $this->configs;
    }

    public function getConfig($key = '')
    {
        $configs = $this->getAllConfigs();
        if (isset($configs['application']['configs'][$key])) {
            return $configs['application']['configs'][$key];
        }
    }

    public function getModules($default = array())
    {
        $configs = $this->getAllConfigs();
        if (isset($configs['application']['modules'])) {
            return $configs['application']['modules'];
        }
        return $default;
    }

    public function getFilters($default = array())
    {
        $configs = $this->getAllConfigs();
        if (isset($configs['application']['filters'])) {
            return $configs['application']['filters'];
        }
        return $default;
    }

    public static function get($key = '')
    {
        if (APPLICATION_ENV == 'development') {
            $configs = require APP_PATH.self::APP_CONFG_DIRECTORY.'/development/application.config.php';
        } else {
            $configs = require APP_PATH.self::APP_CONFG_DIRECTORY.'/application.config.php';
        }
        
        if (isset($configs['application']['configs'][$key])) {
            return $configs['application']['configs'][$key];
        }
        return null;
    }
}