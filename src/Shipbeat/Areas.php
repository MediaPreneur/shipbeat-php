<?php

class Shipbeat_Areas
{
    public $shipbeat;

    public function __construct($shipbeat)
    {
        $this->shipbeat = $shipbeat;
    }

    public function query($params)
    {
        $transport = new Shipbeat_Transport($this->shipbeat);
        $response = $transport->get('/areas', $params);
        return $response;
    }
}
