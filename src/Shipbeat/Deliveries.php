<?php

/**
 * Class Shipbeat_Deliveries
 */
class Shipbeat_Deliveries
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
        $this->endpoint = 'deliveries';
    }

    /**
     * @param $id
     * @param null $parameters
     * @return mixed
     */
    public function get($id, $parameters = null)
    {
        return $this->request->get($this->endpoint . '/' . $id, $parameters);
    }

    /**
     * @param null $parameters
     * @return mixed
     */
    public function create($parameters = null)
    {
        return $this->request->post($this->endpoint, $parameters);
    }
}
