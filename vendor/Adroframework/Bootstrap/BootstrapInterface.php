<?php

namespace Adroframework\Bootstrap;

Interface BootstrapInterface
{
    public function runFilters();

    public function route();

    public function afterDispatch();
}