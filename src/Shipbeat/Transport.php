<?php

/**
 * Class Shipbeat_Transport
 */
class Shipbeat_Transport
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $domain;
    /**
     * @var string
     */
    private $mode;

    /**
     * @var Shipbeat
     */
    private $shipbeat;

    /**
     * @param $token
     * @param $mode
     * @param $domain
     */
    function __construct($authData, $mode, $domain, Shipbeat $shipbeat)
    {
        $this->mode = $mode;
        $this->domain = $domain;
        $this->shipbeat = $shipbeat;
        if (is_array($authData))
            $this->token = $this->generateNewToken($authData, $domain);
        else
            $this->token = $authData;


    }

    /**
     * @param $endpoint
     * @param null $parameters
     * @return array
     */
    public function get($endpoint, $parameters = null)
    {
        return $this->baseRequestMethod($endpoint, 'GET', $parameters);
    }

    /**
     * @param $endpoint
     * @param null $postFields
     * @return array
     */
    public function post($endpoint, $postFields = null)
    {
        return $this->baseRequestMethod($endpoint, 'POST', $postFields);
    }

    /**
     * @param $endpoint
     * @param $method
     * @param null $parameters
     * @return array
     */
    private function baseRequestMethod($endpoint, $method, $parameters = null)
    {
        $ch = curl_init();

        // prepare parameters
        if (!is_null($parameters)) {
            $queryParameters = http_build_query($parameters);
            if ($method == 'POST')
                curl_setopt($ch, CURLOPT_POSTFIELDS, $queryParameters);
            if ($method == 'GET')
                $endpoint = $endpoint . '?' . $queryParameters;
        }

        // set verification only in live mode
        if ($this->mode == 'test')
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        else
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

        curl_setopt($ch, CURLOPT_URL, $this->domain . '/' . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_USERPWD, $this->token);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $result = $this->curl_exec($ch);

        $headers = $this->getHeaders($result);
        $body = substr($result, $this->curl_getinfo($ch, CURLINFO_HEADER_SIZE));

        curl_close($ch);

        // create response and set total_count if exists to Shipbeat
        if (array_key_exists('X-Total-Count', $headers)) {
            $response = new stdClass();
            $response->pagination = array('total' => $headers['X-Total-Count']);
            $response->data = json_decode($body);
        } else
            $response = json_decode($body);

        var_dump($response);

        return $response;
    }

    /**
     * @param $response
     * @return array
     */
    private function getHeaders($response)
    {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line) {
            if ($i === 0)
                $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        }
        return $headers;
    }

    /**
     * @param $ch
     * @return mixed
     */
    protected function curl_exec($ch)
    {
        return curl_exec($ch);
    }

    /**
     * @param $ch
     * @param $option
     * @return mixed
     */
    protected function curl_getinfo($ch, $option)
    {
        return curl_getinfo($ch, $option);
    }

    /**
     * @param $authArray
     * @return mixed
     */
    private function generateNewToken($authArray)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->domain . '/tokens');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . base64_encode($authArray['username'] . ':' . $authArray['password']), 'Content-Length: 0']);
        $result = $this->curl_exec($ch);

        return json_decode($result, true)['key'];
    }
}
