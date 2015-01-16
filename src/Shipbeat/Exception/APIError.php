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
     * @param array $response
     */
    public function __construct($response)
    {
        if (array_key_exists('message', $response)) {
            $this->message = $response['message'];
        }
        if (array_key_exists('description', $response)) {
            $this->description = $response['description'];
        }
        if (array_key_exists('code', $response)) {
            $this->code = $response['code'];
        }

        parent::__construct();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $str = "message: " . $this->message . "\n";
        $str .= "description: " . $this->description . "\n";
        $str .= 'code: ' . $this->code;
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
