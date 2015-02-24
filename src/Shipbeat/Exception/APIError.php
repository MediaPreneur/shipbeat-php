<?php

/**
 * Class Shipbeat_Exception_APIError
 */
class Shipbeat_Exception_APIError extends Shipbeat_Exception_Base
{
    /**
     * @var string
     */
    protected $description = '';

    /**
     * @param array     $response
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($response, $code = 0, Exception $previous = null)
    {
        $message = '';

        if (array_key_exists('message', $response)) {
            $message = $response['message'];
        }

        if (array_key_exists('code', $response)) {
            $code = $response['code'];
        }

        if (array_key_exists('description', $response)) {
            $this->description = $response['description'];
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $str  = "Message: " . $this->message . "\n";
        $str .= "Description: " . $this->description . "\n";
        $str .= 'Code: ' . $this->code;
        return $str;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
