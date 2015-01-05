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
        $transport = new Shipbeat_Transport();
        $response = $transport->get('/areas', $params);

        if ($transport->pagination) {
            $this->shipbeat->pagination = $transport->pagination;
        }

        return $response;
    }
}
