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
     * @param $token
     * @param $mode
     * @param $domain
     */
    function __construct($token, $mode, $domain)
    {
        $this->token = $token;
        $this->mode = $mode;
        $this->domain = $domain;
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

        $code = $this->curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = $this->getHeaders($result);
        $body = json_decode(substr($result, $this->curl_getinfo($ch, CURLINFO_HEADER_SIZE)));

        curl_close($ch);

        // create response with total_count if exists
        $response = array('code' => $code, 'response' => $body);
        if (array_key_exists('X-Total-Count', $headers))
            $response['total_count'] = $headers['X-Total-Count'];

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
}
