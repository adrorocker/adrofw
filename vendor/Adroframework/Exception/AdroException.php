<?php

namespace Adroframework\Exception;

class AdroException extends \Exception
{
    protected $type;
    protected $file;
    protected $line;
    protected $message;

    public function __construct($m = null)
    {
        $this->setMessage($m);
    }

    public function setLine($n = 0)
    {
        $this->line = $this->line  - $n;
        return $this;
    }

    public function setType($t = null)
    {
        $this->type = $t;
        return $this;
    }

    public function setMessage($m = null)
    {
        $this->message = $m;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
}