<?php

/**
 * Class Shipbeat_Exception_APIFatalError
 */
class Shipbeat_Exception_APIFatalError extends Shipbeat_Exception_Base
{
    /**
     * @param null $message
     */
    public function __construct($message = null)
    {
        if ( ! is_null($message)) {
            $this->message = $message;
        }

        parent::__construct();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (String)$this->message;
    }

}
