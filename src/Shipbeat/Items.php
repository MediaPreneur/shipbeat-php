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

    public function all()
    {
        return $this->request->get($this->endpoint);
    }

    public function create($postFields = [])
    {
        return $this->request->post($this->endpoint, $postFields);
    }
}
