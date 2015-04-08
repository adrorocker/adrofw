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

class Bootstrap extends BootstrapAbstract implements BootstrapInterface
{
    public $uri;

    public function __construct()
    {
        $this->uri = new Uri();
        $this->classLoader = new LocalizeClass();
    }

    public function run()
    {
        $this->checkAclAccess();
        $this->route();
        return $this;
    }
}