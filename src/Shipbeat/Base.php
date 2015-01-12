<?php

/**
 * Class Shipbeat_Base
 */
class Shipbeat_Base
{
    /**
     * @var string
     */
    protected  $endpoint;
    /**
     * @var Shipbeat_Transport
     */
    protected  $request;

    /**
     * @param $request
     */
    function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param null $parameters
     * @return mixed
     */
    public function all($parameters = null)
    {
        return $this->request->get($this->endpoint, $parameters);
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
