<?php


namespace Didlogic\Resources;

use Didlogic\HttpClient;

class Resource
{
    protected $id = null;
    protected $properties = [];
    protected $client;

    function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

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

    public function getId()
    {
        return $this->id;
    }
}