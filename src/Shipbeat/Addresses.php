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

    public function get($id, $parameters = null)
    {
        return $this->request->get($this->endpoint . '/' . $id, $parameters);
    }

    public function create($parameters = null)
    {
        return $this->request->post($this->endpoint, $parameters);
    }
}
