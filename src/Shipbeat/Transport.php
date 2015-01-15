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
     * @param $authData
     * @param $mode
     * @param $domain
     */
    function __construct($authData, $mode, $domain)
    {
        $this->mode = $mode;
        $this->domain = $domain;
        if (is_array($authData)) {
            $this->token = $this->generateNewToken($authData, $domain);
        } else {
            $this->token = $authData;
        }


    }

    /**
     * @param $endpoint
     * @param null $parameters
     * @return array
     */
    public function get($endpoint, $parameters = null)
    {
        return $this->baseRequestMethod($endpoint, 'GET', false, $parameters);
    }

    /**
     * @param $endpoint
     * @param null $postFields
     * @return array
     */
    public function post($endpoint, $postFields = null)
    {
        return $this->baseRequestMethod($endpoint, 'POST', false, $postFields);
    }

    /**
     * @param $endpoint
     * @param null $parameters
     * @return array
     */
    public function getRaw($endpoint, $parameters = null)
    {
        return $this->baseRequestMethod($endpoint, 'GET', true, $parameters);
    }

    /**
     * @param $endpoint
     * @param $method
     * @param null $parameters
     * @return array
     */
    private function baseRequestMethod($endpoint, $method, $isRaw, $parameters = null)
    {
        $ch = curl_init();

        // prepare parameters
        if (!is_null($parameters)) {
            $queryParameters = http_build_query($parameters);
            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $queryParameters);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen
                ($queryParameters)));
            }
            if ($method == 'GET') {
                $endpoint = $endpoint . '?' . $queryParameters;
            }
        } elseif (is_null($parameters) && $method == 'POST') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        }


        // set verification only in live mode
        if ($this->mode == 'test') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        }

        curl_setopt($ch, CURLOPT_URL, $this->domain . '/' . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_USERPWD, $this->token);
        if ($isRaw) {
            curl_setopt($ch, CURLOPT_HEADER, 0);
        } else {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $result = $this->curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($isRaw && $code == 200) {
            curl_close($ch);
            return $result;
        }

        $headers = $this->getHeaders($result);
        $body = substr($result, $this->curl_getinfo($ch, CURLINFO_HEADER_SIZE));

        curl_close($ch);

        if ($code != 200) {
            $this->checkResponseCode($code, $body);
        }

        // create response and set total_count if exists to Shipbeat
        if (array_key_exists('X-Total-Count', $headers)) {
            $response = new stdClass();
            $response->pagination = array('total' => (int)$headers['X-Total-Count']);
            $response->data = json_decode($body);
        } else {
            $response = json_decode($body);
        }
        return $response;
    }

    /**
     * @param $response
     * @return array
     */
    private function getHeaders($response)
    {
        $headers = array();

        $headerText = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $headerText) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' .
        base64_encode($authArray['username'] . ':' . $authArray['password']),
            'Content-Length: 0'));
        $result = $this->curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code != 200) {
            $this->checkResponseCode($code, $result);
        }

        return json_decode($result)->key;
    }

    /**
     * @param $code
     * @param $body
     * @throws Shipbeat_Exception_APIFatalError
     * @throws Shipbeat_Exception_APIError
     */
    private function checkResponseCode($code, $body)
    {
        $response = json_decode($body, true);
        if ($code == 404) {
            throw new Shipbeat_Exception_APIError(array('message' => 'Resource not
            found'));
        }
        if ((int)($code / 100) == 4) {
            throw new Shipbeat_Exception_APIError($response);
        }
        if ((int)($code / 100) == 5) {
            throw new Shipbeat_Exception_APIFatalError($response['exception_message']);
        }
    }
}
