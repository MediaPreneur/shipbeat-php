<?php

class Shipbeat_Exception_APIError extends Shipbeat_Exception_Base
{


    public function __construct($message = 'Resource not found')
    {
        $this->message = $message;
        parent::__construct();
    }

    public function __toString()
    {
        return (String)$this->message;
    }

}
