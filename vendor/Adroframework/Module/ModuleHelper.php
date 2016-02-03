<?php

namespace Adroframework\Module;

use Adroframework\Config\Config as Config;

class ModuleHelper
{
    const APP_CONFG_DIRECTORY = 'configs';

    public $acf;

    public function getApplicationConfigFile()
    {
        $config = new Config();
        $this->acf  = $config->getAllConfigs();
        return $this->acf;
    }

    public function getModuleNames()
    {
        $config = $this->getApplicationConfigFile();
        $modulNames = array_keys($config['application']['modules']);
        return $modulNames;
    }
}