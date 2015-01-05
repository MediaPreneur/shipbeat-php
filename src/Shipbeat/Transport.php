<?php

class Shipbeat_Transport {
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
        // TODO: Remember to extract pagination information from the response header
        // TODO: Exceptions should be thrown on errors from here
        // TODO: Response should be JSON Decoded here
    }
}
