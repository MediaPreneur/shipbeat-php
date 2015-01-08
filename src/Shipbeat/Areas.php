<?php

class Shipbeat_Areas
{
    private $endpoint;
    private $request;

    function __construct($request)
    {
        $this->request = $request;
        $this->endpoint = 'areas';
    }

    public function all($parameters = null)
    {
        return $this->request->get($this->endpoint, $parameters);
    }

    public function get($id)
    {
        return $this->request->get($this->endpoint . '/' . $id);
    }
}
