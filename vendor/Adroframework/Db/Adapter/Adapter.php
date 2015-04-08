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

class Adapter implements AdapterInterface
{
    /**
     * Get configurtation to conect to DB
     */
    public function getConfig()
    {
        
    }
}