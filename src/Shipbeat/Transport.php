<?php

class Shipbeat_Transport {
    public $shipbeat;

    public function __construct($shipbeat)
    {
        $this->shipbeat = $shipbeat;
    }

    public function get($endpoint, $params)
    {
        return $this->request('get', $endpoint, $params);
    }

    public function post($endpoint, $params)
    {
        return $this->request('post', $endpoint, $params);
    }

    public function request($method, $endpoint, $params)
    {
        // TODO: Remember to extract pagination information from the response header:
        // $this->shipbeat->pagination = $paginationFromResponseHeader;
        // TODO: Exceptions should be thrown on errors from here
        // TODO: Response should be JSON Decoded here and returned
    }
}
