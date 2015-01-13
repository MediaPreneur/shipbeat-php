<?php

class Shipbeat_NotImplementedException extends Shipbeat_Exception
{
    public function __construct($methodName)
    {
        parent::__construct('Method ' . $methodName . ' not implemented');
    }

    public function __toString()
    {
        $str = 'Exception in ' . $this->getFile() . "\n";
        $str .= "Message: " . $this->message . "\n";
        $str .= "Stack trace:\n" . $this->getTraceAsString();
        return $str;
    }

}
