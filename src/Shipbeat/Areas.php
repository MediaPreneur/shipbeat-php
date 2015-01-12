<?php

/**
 * Class Shipbeat_Areas
 */
class Shipbeat_Areas extends Shipbeat_Base
{
    /**
     * @param $request
     */
    function __construct($request)
    {
        parent::__construct($request);
        $this->endpoint = 'areas';
    }

    function create($parameteres = null)
    {
        throw new Exception('Not implemented');
    }
}
