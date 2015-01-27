<?php

/**
 * Class Shipbeat_Shops
 */
class Shipbeat_Shops
{
	/**
	 * @var string
	 */
	private  $endpoint;

	/**
	 * @var Shipbeat_Transport
	 */
	private  $request;

	/**
	 * @param $request
	 */
	function __construct($request)
	{
		$this->request = $request;
		$this->endpoint = 'shops';
	}

	/**
	 * @param $id
	 * @param array $parameters
	 * @return array
	 */
	public function get($id, $parameters = array())
	{
		return $this->request->get($this->endpoint . '/' . $id, $parameters);
	}

	public function all($parameters = array())
	{
		if (!array_key_exists('limit', $parameters)) {
			$parameters['limit'] = 20;
		}

		if (!array_key_exists('offset', $parameters)) {
			$parameters['offset'] = 0;
		}

		return $this->request->get($this->endpoint, $parameters);
	}
}
