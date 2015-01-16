<?php

/**
 * Class Shipbeat_CarrierProducts
 */
class Shipbeat_CarrierProducts
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
        $this->endpoint = 'carriers/products';
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
}
