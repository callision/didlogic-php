<?php


namespace Didlogic\Http;


class Request
{

    const DEFAULT_API_VERSION = 'v2';

    protected string $method;
    protected string $endpoint;
    protected array $headers = [];
    protected array $params = [];
    protected ?string $apiVersion;

    public function __construct(
        $method = null,
        $endpoint = null,
        array $params = [],
        array $headers = [],
        $apiVersion = null)
    {
        $this->setMethod($method)->setEndpoint($endpoint)->setParams($params);
        $this->apiVersion = $apiVersion ?? self::DEFAULT_API_VERSION;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return Request
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param mixed $endpoint
     * @return Request
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return Request
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return Request
     */
    public function setParams(array $params = []): self
    {
        $this->params = array_merge($this->params, $params);//[...$this->params, ...$params];
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiVersion(): ?string
    {
        return $this->apiVersion;
    }

    public function getUrlEncodedBody(): string
    {
        $params = $this->getPostParams();
        return http_build_query($params, null, '&');
    }

    public function getPostParams(): array
    {
        if ($this->getMethod() === 'POST') {
            return $this->getParams();
        }
        return [];
    }

    public function getUrl(): string
    {
        $this->validateMethod();
        $apiVersion = $this->apiVersion;
        $endpoint = $this->getEndpoint();
        $url = "$apiVersion/$endpoint";

        if ($this->getMethod() !== 'POST') {
            $params = $this->getParams();
            $url = static::appendParamsToUrl($url, $params);
        }
        return $url;
    }

    public function validateMethod()
    {
        if (!$this->method) {
            throw new \Exception('HTTP method not specified.');
        }

        if (!in_array($this->method, ['GET', 'POST', 'DELETE'])) {
            throw new \Exception('Invalid HTTP method specified.');
        }
    }

    public static function appendParamsToUrl(string $url, array $params): string
    {
        if (empty($params)) {
            return $url;
        }
        $getParams = http_build_query($params, null, '&');
        return "{$url}?{$getParams}";
    }

}