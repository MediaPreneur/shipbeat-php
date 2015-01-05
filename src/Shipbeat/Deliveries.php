<?php

class Shipbeat_Deliveries
{
    public $shipbeat;

    public function __construct($shipbeat)
    {
        $this->shipbeat = $shipbeat;
    }

    public function create($params)
    {
        $transport = new Shipbeat_Transport();
        $response = $transport->post('/deliveries', $params);
        return $response;
    }
}
