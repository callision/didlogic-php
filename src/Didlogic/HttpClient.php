<?php


namespace Didlogic;

use Didlogic\Exceptions;
use Didlogic\Http\Request;
use Didlogic\Http\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpClient
{

    const API_ENDPOINT = "https://didlogic.com/api/";
    const DEFAULT_REQUEST_TIMEOUT = 5;

    protected $guzzleClient;
    protected $timeout;
    protected $apiKey;

    /**
     * HttpClient constructor.
     * @param null $apiKey
     */
    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
        $this->guzzleClient = new Client();
    }

    /**
     * @param $url
     * @param $method
     * @param $body
     * @param $headers
     * @param $timeOut
     * @param $request
     * @return Response
     * @throws Exceptions\RequestException
     */
    private function send_request($url, $method, $body, $headers, $timeOut, Request $request): Response
    {
        $request->setHeaders($headers);
        $options = [
            'http_errors' => false,
            'headers' => $headers,
            'body' => $body,
            'timeout' => $timeOut,
            'connect_timeout' => 60
        ];
        try {
            $rawResponse = $this->guzzleClient->request($method, $url, $options);
        } catch (RequestException $e) {
            throw new Exceptions\RequestException($e->getMessage());
        }
        $rawHeaders = $rawResponse->getHeaders();
        $rawBody = $rawResponse->getBody()->getContents();
        $httpStatusCode = $rawResponse->getStatusCode();
        return new Response($request, $httpStatusCode, $rawBody, $rawHeaders);
    }

    /**
     * @param Request $request
     * @return array
     * @throws Exceptions\RequestException
     */
    public function prepareRequestMessage(Request $request)
    {
        $url = self::API_ENDPOINT . $request->getUrl();
        $requestBody = json_encode($request->getParams(), JSON_FORCE_OBJECT);
        return [
            $url,
            $request->getMethod(),
            $request->getHeaders(),
            $requestBody,
        ];
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exceptions\ResponseException
     * @throws Exceptions\RequestException
     */
    public function sendRequest(Request $request): Response
    {
        list($url, $method, $headers, $body) = $this->prepareRequestMessage($request);
        $timeout = $this->timeout ?? static::DEFAULT_REQUEST_TIMEOUT;
        $response = $this->send_request($url, $method, $body, $headers, $timeout, $request);
        if (!$response->ok()) {
            throw $response->getThrownException();
        }
        return $response;
    }

    /**
     * @param $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @param $uri
     * @param array $params
     * @param string|null $apiVersion
     * @return Response
     * @throws Exceptions\ResponseException
     * @throws Exceptions\RequestException
     */
    public function fetch($uri, $params = [], string $apiVersion = null): Response
    {
        $params['apiid'] = $this->apiKey;
        $request = new Request('GET', $uri, $params, [], $apiVersion);
        return $this->sendRequest($request);
    }

    /**
     * @param $uri
     * @param array $params
     * @param string|null $apiVersion
     * @return Response
     * @throws Exceptions\ResponseException
     * @throws Exceptions\RequestException
     */
    public function update($uri, $params = [], string $apiVersion = null): Response
    {
        $params['apiid'] = $this->apiKey;
        $request = new Request('PUT', $uri, $params, [], $apiVersion);
        return $this->sendRequest($request);
    }

    /**
     * @param $uri
     * @param array $params
     * @param string|null $apiVersion
     * @return Response
     * @throws Exceptions\RequestException
     * @throws Exceptions\ResponseException
     */
    public function create($uri, $params = [], string $apiVersion = null): Response
    {
        $params['apiid'] = $this->apiKey;
        $request = new Request('POST', $uri, $params, [], $apiVersion);
        return $this->sendRequest($request);
    }

    /**
     * @param $uri
     * @param array $params
     * @param string|null $apiVersion
     * @return Response
     * @throws Exceptions\ResponseException
     * @throws Exceptions\RequestException
     */
    public function delete($uri, $params = [], string $apiVersion = null): Response
    {
        $params['apiid'] = $this->apiKey;
        $request = new Request('DELETE', $uri, $params, [], $apiVersion);
        return $this->sendRequest($request);
    }
}