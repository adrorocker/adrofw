<?php

namespace Adroframework\Controller;

use Adroframework\Controller\Controller;

class Error extends Controller
{
    protected $error;
    public function __construct($e)
    {
        $this->error = $e;
        parent::__construct();
    }

    public function indexAction()
    {
        $this->view->renderError(array('e' => $this->error));
    }
}