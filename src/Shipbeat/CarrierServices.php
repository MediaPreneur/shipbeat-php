<?php

/**
 * Class Shipbeat_CarrierServices
 */
class Shipbeat_CarrierServices
{
    /**
     * @var string
     */
    private  $endpoint;

    /**
     * @var Shipbeat_Transport
     */
    private  $request;

    /**
     * @param $request
     */
    function __construct($request)
    {
        $this->request = $request;
        $this->endpoint = 'carriers/services';
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
}
