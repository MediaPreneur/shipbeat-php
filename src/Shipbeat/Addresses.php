<?php

class Shipbeat_Addresses
{
    private $endpoint;
    private $request;

    function __construct($request)
    {
        $this->request = $request;
        $this->endpoint = 'addresses';
    }

    public function all()
    {
        return $this->request->get($this->endpoint);
    }

    public function create($postFields = [])
    {
        return $this->request->post($this->endpoint, $postFields);
    }
}
