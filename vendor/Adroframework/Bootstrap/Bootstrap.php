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

class Bootstrap extends BootstrapAbstract implements BootstrapInterface
{
    public $uri;

    public function __construct()
    {
        $this->uri = new Uri();
    }

    public function run()
    {
        $this->checkAclAccess();
        $this->route();
        return $this;
    }
}