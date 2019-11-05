<?php


namespace Didlogic\Resources\Destination;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;

/**
 * Class DestinationInterface
 * @package Didlogic\Resources\Destination
 */
class DestinationInterface extends ResourceInterface
{
    private $didNumber;

    /**
     * DestinationInterface constructor.
     * @param HttpClient $client
     * @param string $didNumber
     */
    public function __construct(HttpClient $client, string $didNumber)
    {
        parent::__construct($client);
        $this->didNumber = $didNumber;
        $this->uri = "purchases/$didNumber/destinations";
    }

    /**
     * @return DestinationList
     * @throws RequestException
     * @throws ResponseException
     */
    public function getList(): DestinationList
    {
        $uri = "$this->uri.json";
        $response = $this->client->fetch($uri, [], 'v1');
        $destinations = [];
        foreach ($response->getContent()['destination'] as $destination) {
            $destination['didNumber'] = $this->didNumber;
            $destinations[] = new Destination($this->client, $destination);
        }
        return new DestinationList(...$destinations);
    }

    /**
     * @param $options
     * @return Destination
     * @throws RequestException
     * @throws ResponseException
     */
    public function create($options): Destination
    {
        $uri = "$this->uri.json";
        $response = $this->client->create($uri, ['destination' => $options], 'v1');
        $destination = $response->getContent()['did_destination'];
        $destination['didNumber'] = $this->didNumber;
        return new Destination($this->client, $destination);
    }

    /**
     * @param $options
     * @return Destination
     * @throws RequestException
     * @throws ResponseException
     */
    public function update($options): Destination
    {
        $uri = "$this->uri/{$options['id']}.json";
        $response = $this->client->update($uri, ['destination' => $options], 'v1');
        $destination = $response->getContent()['did_destination'];
        $destination['didNumber'] = $this->didNumber;
        return new Destination($this->client, $destination);
    }

    /**
     * @param $options
     * @return bool
     * @throws RequestException
     * @throws ResponseException
     */
    public function delete($options): bool
    {
        $uri = "$this->uri/{$options['id']}.json";
        $this->client->delete($uri, [], 'v1');
        return true;
    }
}