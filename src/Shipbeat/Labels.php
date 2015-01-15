<?php

/**
 * Class Shipbeat_Labels
 */
class Shipbeat_Labels
{
    /**
     * @var string
     */
    protected $endpoint;
    /**
     * @var Shipbeat_Transport
     */
    protected $request;

    /**
     * @param $request
     */
    function __construct($request)
    {
        $this->request = $request;
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
     * @param $carrierId
     * @param $locationId
     * @param null $parameters
     * @return array
     */
    public function getLabelForItem($id, $item, $parameters = null)
    {
        return $this->request->get($this->endpoint . '/' . $id . '/' . $item, $parameters);
    }
}
