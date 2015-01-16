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
     * @param array $parameters
     * @return array
     */
    public function get($id, $parameters = array())
    {
        return $this->request->get($this->endpoint . '/' . $id, $parameters);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function create($parameters = array())
    {
        return $this->request->post($this->endpoint, $parameters);
    }
}
