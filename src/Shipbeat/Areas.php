<?php

/**
 * Class Shipbeat_Areas
 */
class Shipbeat_Areas
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
        $this->endpoint = 'areas';
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
}
