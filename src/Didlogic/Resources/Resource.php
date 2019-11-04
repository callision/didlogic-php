<?php


namespace Didlogic\Resources;

use Didlogic\HttpClient;

class Resource
{
    protected $id = null;
    protected $properties = [];
    protected $client;

    /**
     * Resource constructor.
     * @param HttpClient $client
     */
    function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return null;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}