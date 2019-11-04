<?php


namespace Didlogic;

use Didlogic\Http\Request;
use Didlogic\Http\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpClient
{

    const API_ENDPOINT = "https://didlogic.com/api/";
    const DEFAULT_REQUEST_TIMEOUT = 5;

    protected Client $guzzleClient;
    protected int $timeout;
    protected string $apiKey;

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
     * @throws GuzzleException
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
        $rawResponse = $this->guzzleClient->request($method, $url, $options);
        $rawHeaders = $rawResponse->getHeaders();
        $rawBody = $rawResponse->getBody()->getContents();
        $httpStatusCode = $rawResponse->getStatusCode();
        return new Response($request, $httpStatusCode, $rawBody, $rawHeaders);
    }

    /**
     * @param Request $request
     * @return array
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
     * @throws GuzzleException
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
     * @return Response
     * @throws Exceptions\ResponseException
     * @throws GuzzleException
     */
    public function fetch($uri, $params = []): Response
    {
        $params['apiid'] = $this->apiKey;
        $request = new Request('GET', $uri, $params);
        return $this->sendRequest($request);
    }

    /**
     * @param $uri
     * @param array $params
     * @return Response
     * @throws Exceptions\ResponseException
     * @throws GuzzleException
     */
    public function update($uri, $params = []): Response
    {
        $params['apiid'] = $this->apiKey;
        $request = new Request('POST', $uri, $params);
        return $this->sendRequest($request);
    }

    /**
     * @param $uri
     * @param array $params
     * @return Response
     * @throws Exceptions\ResponseException
     * @throws GuzzleException
     */
    public function delete($uri, $params = []): Response
    {
        $params['apiid'] = $this->apiKey;
        $request = new Request('DELETE', $uri, $params);
        return $this->sendRequest($request);
    }
}