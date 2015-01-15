<?php

/**
 * Class Shipbeat_Labels
 */
class Shipbeat_Labels
{
    /**
     * @var string
     */
    protected $domain;

    /**
     * @param $domain
     */
    function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param $id
     * @param null $parameters
     * @return string
     */
    public function get($id, $parameters = null)
    {
        $queryParameters = '';
        if (!is_null($parameters)) {
            $queryParameters = '?' . http_build_query($parameters);
        }
        return $this->domain . '/' . $id . $queryParameters;
    }

    /**
     * @param $labelId
     * @param $itemId
     * @param null $parameters
     * @return string
     */
    public function getLabelForItem($labelId, $itemId, $parameters = null)
    {
        $queryParameters = '';
        if (!is_null($parameters)) {
            $queryParameters = '?' . http_build_query($parameters);
        }
        return $this->domain . '/' . $labelId . '/' . $itemId . $queryParameters;
    }
}
