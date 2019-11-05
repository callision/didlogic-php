<?php

namespace Didlogic\Resources;

use Didlogic\HttpClient;

/**
 * Class ResourceInterface
 * @package Didlogic\Resources
 */
class ResourceInterface
{
    /**
     * @var HttpClient
     */
    protected $client;
    /**
     * @var string
     */
    protected $uri;

    /**
     * ResourceInterface constructor.
     * @param HttpClient $client
     */
    function __construct(HttpClient $client)
    {
        $this->client = $client;
    }
}