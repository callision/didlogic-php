<?php


namespace Didlogic\Resources\Destination;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\Resource;

/**
 * @property int id
 * @property string destination
 * @property int priority
 * @property boolean callhunt
 * @property boolean active
 * @property int transport
 * @property string didNumber
 */
class Destination extends Resource
{
    /**
     * @var DestinationInterface
     */
    private $interface;

    /**
     * Destination constructor.
     * @param HttpClient $client
     * @param $data
     */
    public function __construct(HttpClient $client, $data)
    {
        parent::__construct($client);
        $this->properties = [
            'id' => (int)$data['id'],
            'destination' => (string)$data['destination'],
            'priority' => (int)$data['priority'],
            'callhunt' => (boolean)$data['callhunt'],
            'active' => (boolean)$data['active'],
            'transport' => (int)$data['transport'],
            'didNumber' => (string)$data['didNumber']
        ];
    }

    /**
     * @return DestinationInterface
     */
    private function getInterface(): DestinationInterface
    {
        if (!$this->interface) {
            $this->interface = new DestinationInterface($this->client, $this->didNumber);
        }
        return $this->interface;
    }

    /**
     * @return Destination
     * @throws RequestException
     * @throws ResponseException
     */
    public function update(): self
    {
        $this->getInterface()->update($this->getParams());
        return $this;
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     */
    public function delete(): void
    {
        $this->getInterface()->delete($this->getParams());
    }

    /**
     * @param $value
     */
    private function setId($value): void
    {

    }

    /**
     * @param $value
     */
    private function setDidNumber($value): void
    {

    }
}