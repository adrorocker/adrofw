<?php

namespace Adroframework\Bootstrap;

Interface BootstrapInterface
{
    public function getAclInstance();

    public function setAclInstance();

    public function checkAclAccess();

    public function route();
}