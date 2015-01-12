<?php

/**
 * Class Shipbeat_Manifests
 */
class Shipbeat_Manifests
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
        $this->endpoint = 'manifests';
    }

    /**
     * @param $carrierId
     * @param $locationId
     * @param null $parameters
     * @return array
     */
    public function get($carrierId, $locationId, $parameters = null)
    {
        return $this->request->get($this->endpoint . '/' . $carrierId . '/' . $locationId, $parameters);
    }
}
