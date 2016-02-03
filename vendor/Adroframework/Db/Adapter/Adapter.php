<?php

/**
 * Database Adapter Interface
 *
 * @author Adro Rocker <alejandro.morelos@jarwebdev.com>
 * @package Adroframework
 * @subpackage Db
 **/

namespace Adroframework\Db\Adapter;

use Adroframework\Db\Adapter\AdapterInterface;
use Adroframework\Config\Config;

class Adapter extends \PDO implements AdapterInterface
{
    protected $configs;

    public function __construct() {
        $configs = $this->getConfigs();
        parent::__construct(
                            $configs['dbtype']. ':host=' . $configs['dbhost'] .
                            ';dbname=' . $configs['dbname'], $configs['dbuser'], $configs['dbpass']
                            );
    }

    /**
     * Get configurtation to conect to DB
     */
    public function getConfigs()
    {
        if (!isset($this->configs) && !is_array($this->configs)) { 
            $config = Config::get('db');
            $this->configs = require $config['configfile'];
        }
        return $this->configs;
    }
}