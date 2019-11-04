<?php


namespace Didlogic\Resources;

use Didlogic\HttpClient;

/**
 * Class Resource
 * @package Didlogic\Resources
 */
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
     * @param $input
     * @param string $separator
     * @return string
     */
    private function toCamelCase($input, $separator = '_'): string
    {
        return str_replace($separator, '', lcfirst(ucwords($input, $separator)));
    }

    /**
     * @param $string
     * @return string
     */
    private function toSnakeCase($string): string
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        $name = $this->toCamelCase($name);
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value): void
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
            return;
        }
        if (array_key_exists($name, $this->properties)) {
            $this->properties[$name] = $value;
            return;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    protected function getParams(): array
    {
        $params = [];
        foreach ($this->properties as $key => $value) {
            $params[$this->toSnakeCase($key)] = $value;
        }
        return $params;
    }
}