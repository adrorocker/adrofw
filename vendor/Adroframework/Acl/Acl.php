<?php

/**
 * Access Control List
 * 
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 * @package Adroframework
 * @subpackage Acl
 */

namespace Adroframework\Acl;

use Adroframework\Acl\Role\Role;
use Adroframework\Registry\Registry;
use Adroframework\Config\Config;


class Acl
{

    private $roles = array();
    private $resources = array();

    function __construct()
    {
        
    }

    public function addRole($role, $parent = null)
    {
        if (in_array($parent, $this->roles)) {
            array_push($this->roles, $role);
            $parentRole = Registry::get($parent);
            if (null != $parentRole) {
                $roleResources = $parentRole->getResources();
                $aclRole = new Role();
                foreach ($roleResources as $resource) {
                    $aclRole->addResource($resource);
                    $this->allow($role, $resource);
                }
                Registry::add($aclRole, $role);
            }
        } else {
            if (!in_array($role, $this->roles)) {
                array_push($this->roles, $role);
                $aclRole = new Role();
                Registry::add($aclRole, $role);
            }
        }
    }

    public function addResource($resource)
    {
        if (!in_array($resource, $this->resources)) {
            array_push($this->resources, $resource);
        }
    }

    public function allow($role, $resource)
    {
        if (
            in_array($resource, $this->resources) &&
            in_array($role, $this->roles)
        ) {
            $isRoleSet = Registry::get($role);
            if (null != $isRoleSet) {
                $aclRole = Registry::get($role);
                $aclRole->addResource($resource);
                Registry::add($aclRole, $role);
            } else {
                $aclRole = new Role();
                $aclRole->addResource($resource);
                Registry::add($aclRole, $role);
            }
        }
    }
}