<?php

class Shipbeat_Items
{
    private $endpoint;
    private $request;

    function __construct($request)
    {
        $this->request = $request;
        $this->endpoint = 'items';
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
