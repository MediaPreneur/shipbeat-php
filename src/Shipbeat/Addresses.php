<?php

/**
 * Class Shipbeat_Addresses
 */
class Shipbeat_Addresses
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var Shipbeat_Transport
     */
    private $request;

    /**
     * @param $request
     */
    function __construct($request)
    {
        $this->request = $request;
        $this->endpoint = 'addresses';
    }

    /**
     * @param $id
     * @param null $parameters
     * @return mixed
     */
    public function get($id, $parameters = [])
    {
        return $this->request->get($this->endpoint . '/' . $id, $parameters);
    }

    /**
     * @param null $parameters
     * @return mixed
     */
    public function create($parameters = [])
    {
        return $this->request->post($this->endpoint, $parameters);
    }
}
