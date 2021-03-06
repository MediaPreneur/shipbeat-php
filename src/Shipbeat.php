<?php

/**
 * Class Shipbeat
 */
class Shipbeat
{
    /**
     * @var Shipbeat_Items
     */
    private $items;

    /**
     * @var Shipbeat_Areas
     */
    private $areas;

    /**
     * @var Shipbeat_DeliveryPoints
     */
    private $deliveryPoints;

    /**
     * @var Shipbeat_Addresses
     */
    private $addresses;

    /**
     * @var Shipbeat_Quotes
     */
    private $quotes;

    /**
     * @var Shipbeat_Deliveries
     */
    private $deliveries;

    /**
     * @var Shipbeat_Labels
     */
    private $labels;

    /**
     * @var Shipbeat_Carriers
     */
    private $carriers;

    /**
     * @var Shipbeat_CarrierServices
     */
    private $carrierServices;

    /**
     * @var Shipbeat_CarrierProducts
     */
    private $carrierProducts;

    /**
     * @var Shipbeat_Shops
     */
    private $shops;

    /**
     * @param string|array $authData
     * @param string $mode
     */
    public function __construct($authData, $mode = 'production')
    {
        // Determine correct domains based on environment
        if ($mode == 'test') {
            $domain = 'https://api.test.shipbeat.com';
            $labelDomain = 'https://label.test.shipbeat.com';
        } else {
            $domain = 'https://api.shipbeat.com';
            $labelDomain = 'https://label.shipbeat.com';
        }

        // Initialize the transport class, which is the main gateway between
        // the developer's code and Shipbeat API
        $request = new Shipbeat_Transport($authData, $mode, $domain);

        // Initialize an instance of each available resource
        $this->items = new Shipbeat_Items($request);
        $this->areas = new Shipbeat_Areas($request);
        $this->deliveryPoints = new Shipbeat_DeliveryPoints($request);
        $this->addresses = new Shipbeat_Addresses($request);
        $this->quotes = new Shipbeat_Quotes($request);
        $this->deliveries = new Shipbeat_Deliveries($request);
        $this->labels = new Shipbeat_Labels($labelDomain);
        $this->carriers = new Shipbeat_Carriers($request);
        $this->carrierServices = new Shipbeat_CarrierServices($request);
        $this->carrierProducts = new Shipbeat_CarrierProducts($request);
        $this->shops = new Shipbeat_Shops($request);
    }

    /**
     * @return Shipbeat_Items
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * @return Shipbeat_Areas
     */
    public function areas()
    {
        return $this->areas;
    }

    /**
     * @return Shipbeat_DeliveryPoints
     */
    public function deliveryPoints()
    {
        return $this->deliveryPoints;
    }

    /**
     * @return Shipbeat_Addresses
     */
    public function addresses()
    {
        return $this->addresses;
    }

    /**
     * @return Shipbeat_Quotes
     */
    public function quotes()
    {
        return $this->quotes;
    }

    /**
     * @return Shipbeat_Deliveries
     */
    public function deliveries()
    {
        return $this->deliveries;
    }

    /**
     * @return Shipbeat_Labels
     */
    public function labels()
    {
        return $this->labels;
    }

    /**
     * @return Shipbeat_Carriers
     */
    public function carriers()
    {
        return $this->carriers;
    }

    /**
     * @return Shipbeat_CarrierServices
     */
    public function carrierServices()
    {
        return $this->carrierServices;
    }

    /**
     * @return Shipbeat_CarrierProducts
     */
    public function carrierProducts()
    {
        return $this->carrierProducts;
    }

    /**
     * @return Shipbeat_Shops
     */
    public function shops()
    {
        return $this->shops;
    }
}
