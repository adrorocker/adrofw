<?php

/**
 * Access Control List Role
 * 
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 * @package Adroframework
 * @subpackage Acl
 */

namespace Adroframework\Acl\Role;

class Role
{
    private $resources = array();
    
    function __construct()
    {
        
    }

    public function addResource($resource)
    {
        array_push($this->resources, $resource);
    }

    public function getResources()
    {
        return $this->resources;
    }
    
}