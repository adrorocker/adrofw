<?php

namespace Adroframework\Controller;

use Adroframework\View\View;

class Controller extends ControllerAbstract
{
    protected $view;
    public function __construct()
    {
        $this->view = new View();
    }

    protected function layout()
    {
        return $this->view;
    }
}