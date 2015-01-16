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
     * @param array $parameters
     * @return mixed|stdClass
     */
    public function get($endpoint, $parameters = array())
    {
        return $this->baseRequestMethod($endpoint, 'GET', false, $parameters);
    }

    /**
     * @param $endpoint
     * @param array $postFields
     * @return mixed|stdClass
     */
    public function post($endpoint, $postFields = array())
    {
        return $this->baseRequestMethod($endpoint, 'POST', false, $postFields);
    }

    /**
     * @param $endpoint
     * @param array $parameters
     * @return mixed|stdClass
     */
    public function getRaw($endpoint, $parameters = array())
    {
        return $this->baseRequestMethod($endpoint, 'GET', true, $parameters);
    }

    /**
     * @param $endpoint
     * @param $method
     * @param $isRaw
     * @param array $parameters
     * @return mixed|stdClass
     */
    private function baseRequestMethod($endpoint, $method, $isRaw, $parameters = array())
    {
        $ch = curl_init();

        // prepare query
        if ($method == 'POST') {
            $this->preparePostQuery($ch, $parameters);
        } elseif ($method == 'GET') {
            $endpoint = $this->prepareGetQuery($endpoint, $parameters);
        }

        $this->setSSLVerification($ch);
        $this->setCommonCurlOptions($ch, $endpoint, $method);

        if ($isRaw) {
            return $this->createRawResponse($ch);
        }
        return $this->createResponse($ch, $parameters);
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

    /**
     * @param $ch
     * @param array $parameters
     */
    private function preparePostQuery(&$ch, $parameters = array())
    {
        if (!empty($parameters)) {
            $queryParameters = http_build_query($parameters);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryParameters);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen
            ($queryParameters)));
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        }
    }

    /**
     * @param $endpoint
     * @param array $parameters
     * @return string
     */
    private function prepareGetQuery($endpoint, $parameters = array())
    {
        if (!empty($parameters)) {
            $queryParameters = http_build_query($parameters);
            $endpoint = $endpoint . '?' . $queryParameters;
        }
        return $endpoint;
    }

    /**
     * @param $ch
     */
    private function setSSLVerification(&$ch)
    {
        if ($this->mode == 'test') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        }
    }

    /**
     * @param $ch
     * @param $endpoint
     * @param $method
     */
    private function setCommonCurlOptions(&$ch, $endpoint, $method)
    {
        curl_setopt($ch, CURLOPT_URL, $this->domain . '/' . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_USERPWD, $this->token);
        curl_setopt($ch, CURLOPT_HEADER, 1);
    }

    /**
     * @param $ch
     * @return mixed
     */
    private function createRawResponse(&$ch)
    {
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $result = $this->curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($code != 200) {
            $this->checkResponseCode($code, $result);
        }
        return $result;
    }


    /**
     * @param $ch
     * @param $parameters
     * @return mixed|stdClass
     */
    private function createResponse(&$ch, $parameters)
    {
        $result = $this->curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $headers = $this->getHeaders($result);
        $body = substr($result, $this->curl_getinfo($ch, CURLINFO_HEADER_SIZE));

        curl_close($ch);

        if ($code != 200) {
            $this->checkResponseCode($code, $body);
        }

        // decode json body and create response type
        $jsonBody = json_decode($body);
        if (array_key_exists('X-Total-Count', $headers)) {
            return $this->createCollectionResponseWithTotalCount($headers, $jsonBody,
                $parameters);
        } elseif (is_array($jsonBody)) {
            return $this->createCollectionResponse($jsonBody);
        }
        // returning regular response (stdClass)
        return $jsonBody;
    }


    /**
     * @param $headers
     * @param $jsonBody
     * @param $parameters
     * @return stdClass
     */
    private function createCollectionResponseWithTotalCount($headers, $jsonBody,
                                                            $parameters)
    {
        $response = new stdClass();
        $response->pagination = array('total' => (int)$headers['X-Total-Count'],
            'limit' => $parameters['limit'], 'offset' => $parameters['offset']);
        $response->data = $jsonBody;
        $response->count = count($response->data);
        return $response;
    }

    /**
     * @param $jsonBody
     * @return stdClass
     */
    private function createCollectionResponse($jsonBody)
    {
        $response = new stdClass();
        $response->count = count($jsonBody);
        $response->data = $jsonBody;
        return $response;
    }
}
