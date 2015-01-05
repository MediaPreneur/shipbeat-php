<?php

class Shipbeat
{
    public $token;

    public function __construct($auth) {
        if (is_array($auth)) {
            // TODO: Retrieve Token from API
        } else {
            $this->token = $auth;
        }
    }

    public function deliveries()
    {
        return new Shipbeat_Deliveries($this);
    }

    public function areas()
    {
        return new Shipbeat_Areas($this);
    }
}
