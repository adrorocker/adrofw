<?php

namespace Adroframework\Module;

class ModuleHelper
{
    const APP_CONFG_DIRECTORY = 'configs';

    public $acf;

    public function getApplicationConfigFile()
    {
        $this->acf = require APP_PATH.'/'.self::APP_CONFG_DIRECTORY.'/application.config.php';
        return $this->acf;
    }

    public function getModuleNames()
    {
        $config = $this->getApplicationConfigFile();
        $modulNames = array_keys($config['application']['modules']);
        return $modulNames;
    }
}