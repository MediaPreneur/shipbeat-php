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
     * @param array $parameters
     * @return string
     */
    public function get($id, $parameters = array())
    {
        return $this->domain . '/' . $id .  $this->buildQueryParameters($parameters);
    }

    /**
     * @param $labelId
     * @param $itemId
     * @param array $parameters
     * @return string
     */
    public function getLabelForItem($labelId, $itemId, $parameters = array())
    {
        return $this->domain . '/' . $labelId . '/' . $itemId .
        $this->buildQueryParameters($parameters);
    }

   /**
   * @param $parameters
   * @return string
   */
   private function buildQueryParameters($parameters)
   {
       $queryParameters = '';
       if (!empty($parameters)) {
           $queryParameters = '?' . http_build_query($parameters);
       }
       return $queryParameters;
   }
}
