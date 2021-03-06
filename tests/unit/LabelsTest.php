<?php

/**
 * Shipbeat_Labels test cases
 */
class Shipbeat_LabelsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Labels
     */
    private $labels;

    /**
     * @var string
     */
    private $expectedGet;

    /**
     * @var string
     */
    private $expectedGetLabelForItem;

    /**
    * @var string
    */
    private $expectedGetWithParameters;

    /**
    * @var string
    */
    private $expectedGetLabelForItemWithParameters;

    /**
     * @var string
     */
    private $domain = 'domain';

    /**
     * @var string
     */
    private $id = 'id';

    /**
     * @var string
     */
    private $item = 'item';

    /**
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $this->expectedGet = $this->domain . '/' . $this->id;
        $this->expectedGetLabelForItem = $this->domain . '/' . $this->id . '/' .
            $this->item;
        $this->expectedGetWithParameters = $this->expectedGet .
        '?one=one&two=two';
        $this->expectedGetLabelForItemWithParameters =
        $this->expectedGetLabelForItem . '?one=one&two=two';
        $this->labels = new Shipbeat_Labels($this->domain);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->labels = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testGet()
    {
        $result = $this->labels->get($this->id);
        $this->assertEquals($this->expectedGet, $result);
    }

    /**
    * Test get() method
    */
    public function testGetWithParameters()
    {
      $result = $this->labels->get($this->id, array('one' => 'one', 'two' => 'two'));
      $this->assertEquals($this->expectedGetWithParameters, $result);
    }

    /**
     * Test getLabelForItem() method
     */
    public function testGetLabelForItem()
    {
        $result = $this->labels->getLabelForItem($this->id, $this->item);
        $this->assertEquals($this->expectedGetLabelForItem, $result);
    }

    /**
    * Test getLabelForItem() method
    */
    public function testGetLabelForItemWithParameters()
    {
      $result = $this->labels->getLabelForItem($this->id, $this->item,
      array('one' => 'one', 'two' => 'two'));
      $this->assertEquals($this->expectedGetLabelForItemWithParameters, $result);
    }
}
