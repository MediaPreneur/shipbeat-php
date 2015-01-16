<?php

/**
 * Class Shipbeat_Quotes
 */
class Shipbeat_Quotes
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
        $this->endpoint = 'quotes';
    }

    /**
     * @param $id
     * @param null $parameters
     * @return mixed
     */
    public function get($id, $parameters = array())
    {
        return $this->request->get($this->endpoint . '/' . $id, $parameters);
    }

    /**
     * @param null $parameters
     * @return mixed
     */
    public function create($parameters = array())
    {
        return $this->request->post($this->endpoint, $parameters);
    }
}
