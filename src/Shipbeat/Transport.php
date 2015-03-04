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

        // Generate a new session token if no long-lived token is provided
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
        // cURL handle
        $ch = curl_init();

        // Prepare query
        if ($method == 'POST') {
            $this->preparePostQuery($ch, $parameters);
        } elseif ($method == 'GET') {
            $endpoint = $this->prepareGetQuery($endpoint, $parameters);
        }

        // Set common options
        $this->setSSLVerification($ch);
        $this->setCommonCurlOptions($ch, $endpoint, $method);

        // Return unmodified response (for example when downloading PDF data)
        if ($isRaw) {
            return $this->createRawResponse($ch);
        }

        // Return a parsed response
        return $this->createResponse($ch, $parameters);
    }

    /**
     * @param $response
     * @return array
     */
    private function getHeaders($response)
    {
        // Contains headers split into key-value pairs
        $headers = array();

        // Raw headers from cURL response
        $headerText = substr($response, 0, strpos($response, "\r\n\r\n"));

        // Parse headers
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
        // Initialize a new cURL handle
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->domain . '/tokens');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        // Create authentication data for cURL
        $encodedAuth = base64_encode($authArray['username'] . ':' . $authArray['password']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . $encodedAuth,
            'Content-Length: 0'
        ));

        // Make the request
        $result = $this->curl_exec($ch);

        // Get HTTP response code
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Throw an error in case of a problem
        if ($code != 200) {
            $this->checkResponseCode($code, $result);
        }

        // Return session token
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
        // Shipbeat API provides friendly JSON errors, therefore we can parse
        // them and get more information about the problem that has occured
        $response = json_decode($body, true);

        // Unfortunately, 404 errors are currently HTML based, therefore we need
        // to create an error message ourselves
        if ($code == 404) {
            throw new Shipbeat_Exception_APIError(array(
                'message' => 'Resource not found',
                'code'    => $code,
            ));
        }

        // 4xx error codes map directly to `Shipbeat_Exception_APIError` class
        if ((int)($code / 100) == 4) {
            throw new Shipbeat_Exception_APIError($response);
        }

        // 5xx errors are not Shipbeat API friendly errors, but we can still map
        // them
        if ((int)($code / 100) == 5) {
            throw new Shipbeat_Exception_APIFatalError($response['message'], $code);
        }
    }

    /**
     * @param $ch
     * @param array $parameters
     */
    private function preparePostQuery(&$ch, $parameters = array())
    {
        // Sets correct content length and POST body
        if ( ! empty($parameters)) {
            $queryParameters = http_build_query($parameters);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryParameters);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Length: ' . strlen($queryParameters)
            ));
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
        // Generates a new endpoint containing the GET query
        if ( ! empty($parameters)) {
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
        // In test environment we don't want to verify SSL peer
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
        // Return request without headers
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // Fetch the response
        $result = $this->curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL connection
        curl_close($ch);

        // Throw exceptions if problems occurred
        if ($code != 200) {
            $this->checkResponseCode($code, $result);
        }

        // Return raw response
        return $result;
    }


    /**
     * @param $ch
     * @param $parameters
     * @return mixed|stdClass
     */
    private function createResponse(&$ch, $parameters)
    {
        // Fetch response, HTTP code and headers
        $result = $this->curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = $this->getHeaders($result);

        // Strip headers from response
        $body = substr($result, $this->curl_getinfo($ch, CURLINFO_HEADER_SIZE));

        // Close cURL connection
        curl_close($ch);

        // Throw exceptions if problems occurred
        if ($code != 200) {
            $this->checkResponseCode($code, $body);
        }

        // Decode json body and create correct response type
        $jsonBody = json_decode($body);

        if (array_key_exists('X-Total-Count', $headers)) {
            // Return paginated collection
            return $this->createCollectionResponseWithTotalCount($headers, $jsonBody, $parameters);
        } elseif (is_array($jsonBody)) {
            // Return simple collection
            return $this->createCollectionResponse($jsonBody);
        }

        // Returning regular response (`stdClass` from `json_decode`)
        return $jsonBody;
    }


    /**
     * @param $headers
     * @param $jsonBody
     * @param $parameters
     * @return stdClass
     */
    private function createCollectionResponseWithTotalCount($headers, $jsonBody, $parameters)
    {
        // Create a new class with pagination information, response and current
        // collection size
        $response = new stdClass();
        $response->data = $jsonBody;
        $response->count = count($response->data);
        $response->pagination = array(
            'total' => (int)$headers['X-Total-Count'],
            'limit' => $parameters['limit'],
            'offset' => $parameters['offset']
        );

        return $response;
    }

    /**
     * @param $jsonBody
     * @return stdClass
     */
    private function createCollectionResponse($jsonBody)
    {
        // Create a new class with collection size and collection itself
        $response = new stdClass();
        $response->count = count($jsonBody);
        $response->data = $jsonBody;

        return $response;
    }
}
