<?php

/**
 * Bootstrap
 * 
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 * @package Adroframework
 * @subpackage Bootstrap
 */

namespace Adroframework\Bootstrap;

use Adroframework\Bootstrap\BootstrapAbstract as BootstrapAbstract;
use Adroframework\Bootstrap\BootstrapInterface as BootstrapInterface;
use Adroframework\Http\Uri as Uri;
use Adroframework\Loader\LocalizeClass as LocalizeClass;
use Adroframework\Config\Config as Config;

class Bootstrap extends BootstrapAbstract implements BootstrapInterface
{
    public $uri;

    protected $classLoader;

    protected $configLoader;

    /**
     * Application config file
     */
    protected $acf;

    public function __construct()
    {
        $this->uri = new Uri();
        $this->classLoader = new LocalizeClass();
        $this->configLoader = new Config();
    }

    public function run()
    {
        $this->runFilters();
        $this->route();
        $this->afterDispatch();
        return $this;
    }
}