<?php

/**
 * Class Shipbeat_Carriers
 */
class Shipbeat_Carriers extends Shipbeat_Base
{
    /**
     * @param $request
     */
    function __construct($request)
    {
        parent::__construct($request);
        $this->endpoint = 'carriers';
    }

    function create($parameteres = null)
    {
        throw new Exception('Not implemented');
    }
}
