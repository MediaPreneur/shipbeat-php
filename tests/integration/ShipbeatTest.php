<?php

/**
 * Class Shipbeat integration tests
 */
class ShipbeatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat
     */
    private $shipbeat;

    /**
     * @var string or array
     */
    private $authData = "Your Shipbeat API token or array('username' => Your username,
    'password' => Your password)";


    /**
     * @var string
     */
    private $mode = 'test';

    /**
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $this->shipbeat = new Shipbeat($this->authData, $this->mode);
        parent::setUp();
    }

    /**
     * test getting a label for accepted quoteZ
     */
    public function testGetLabelForAcceptedQuote()
    {
        $itemsParams = array(
            'item_template' => 'size_s',
            'value' => 179
        );
        $items = $this->shipbeat->items()->create($itemsParams);
        $this->assertNotNull($items);
        $this->assertInstanceOf('stdClass', $items);

        $AddressesParamsFrom = array(
            'name1' => 'From',
            'name2' => 'Shipbeat',
            'street1' => 'From street',
            'postal_code' => '2100',
            'city' => 'København Ø',
            'country_code' => 'DK'
        );
        $addressesFrom = $this->shipbeat->addresses()->create($AddressesParamsFrom);
        $this->assertNotNull($addressesFrom);
        $this->assertInstanceOf('stdClass', $addressesFrom);

        $AddressesParamsTo = array(
            'name1' => 'To',
            'name2' => 'Shipbeat',
            'street1' => 'To street',
            'postal_code' => '2100',
            'city' => 'København Ø',
            'country_code' => 'DK'
        );
        $addressesTo = $this->shipbeat->addresses()->create($AddressesParamsTo);
        $this->assertNotNull($addressesTo);
        $this->assertInstanceOf('stdClass', $addressesTo);

        $quotesParams = array('delivery_option' => 'standard_delivery',
            'item' => $items->id, 'from' => $addressesFrom->id, 'to' => $addressesTo->id);
        $quotes = $this->shipbeat->quotes()->create($quotesParams);
        $this->assertNotNull($quotes);
        $this->assertInstanceOf('stdClass', $quotes);

        $deliveriesParams = array('quote' => $quotes->data[0]->id);
        $deliveries = $this->shipbeat->deliveries()->create($deliveriesParams);
        $this->assertNotNull($deliveries);
        $this->assertInstanceOf('stdClass', $deliveries);

        $label = $this->shipbeat->labels()->get($deliveries->label_id);
        $this->assertNotNull($label);
        $this->assertInternalType('string', $label);
    }


}
