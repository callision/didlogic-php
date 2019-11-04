<?php

namespace Didlogic\Resources;

use Didlogic\HttpClient;

class ResourceInterface
{
    protected $client;
    protected $uri;

    function __construct(HttpClient $client)
    {
        $this->client = $client;
    }
}