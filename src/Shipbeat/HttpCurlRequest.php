<?php

class Shipbeat_HttpCurlRequest
{
    private $token;
    private $domain;
    private $mode;

    function __construct($token, $mode, $domain)
    {
        $this->token = $token;
        $this->mode = $mode;
        $this->domain = $domain;
    }

    public function get($endpoint, $parameters = null)
    {
        return $this->baseRequestMethod($endpoint, 'GET', $parameters);
    }

    public function post($endpoint, $postFields = null)
    {
        return $this->baseRequestMethod($endpoint, 'POST', $postFields);
    }

    private function baseRequestMethod($endpoint, $method, $parameters = null)
    {
        $ch = curl_init();

        if (!is_null($parameters)) {
            $queryParameters = http_build_query($parameters);
            if ($method == 'POST')
                curl_setopt($ch, CURLOPT_POSTFIELDS, $queryParameters);
            if ($method == 'GET')
                $endpoint = $endpoint . '?' . $queryParameters;
        }

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

        $result = curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = $this->getHeaders($result);
        $body = json_decode(substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE)));

        curl_close($ch);

        $response = array('code' => $code, 'response' => $body, true);
        if (array_key_exists('X-Total-Count', $headers))
            $response['total_count'] = $headers['X-Total-Count'];

        return $response;
    }

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
}
