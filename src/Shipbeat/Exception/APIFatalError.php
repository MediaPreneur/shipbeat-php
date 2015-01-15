<?php

class Shipbeat_Exception_APIFatalError extends Shipbeat_Exception_Base
{
    protected $message = '';
    protected $description = '';
    protected $code = '';

    public function __construct($response)
    {
        var_dump($response);

        if (array_key_exists('message', $response))
            $this->message = $response['message'];
        if (array_key_exists('description', $response))
            $this->description = $response['description'];
        if (array_key_exists('code', $response))
            $this->code = $response['code'];

        parent::__construct();
    }

    public function __toString()
    {
        $str = "message: " . $this->message . "\n";
        $str .= "description: " . $this->description . "\n";
        $str .= 'code: ' . $this->code;
        return $str;
    }
}
