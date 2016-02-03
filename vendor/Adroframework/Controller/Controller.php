<?php

namespace Adroframework\Controller;

use Adroframework\View\View;
use Adroframework\Http\Request;

class Controller extends ControllerAbstract
{
    protected $view;
    protected $request;

    public function __construct()
    {
        $this->view = new View();
        $this->request = new Request();    }

    protected function layout()
    {
        return $this->view;
    }

    protected function getParam($key = '')
    {
        return $this->request->getParam($key);
    }
}