<?php


namespace Didlogic\Resources\City;


use Didlogic\HttpClient;
use Didlogic\Resources\Did\DidInterface;
use Didlogic\Resources\Resource;

/**
 * @property int countryId
 * @property string name
 * @property int areaCode
 */
class City extends Resource
{
    /**
     * @var DidInterface
     */
    private $dids;

    /**
     * City constructor.
     * @param HttpClient $client
     * @param $data
     */
    public function __construct(HttpClient $client, $data)
    {
        parent::__construct($client);
        $this->properties = [
            'id' => (int)$data['id'],
            'countryId' => (int)$data['country_id'],
            'name' => (string)$data['name'],
            'areaCode' => (int)$data['area_code']
        ];
        $this->id = (int)$data['id'];
    }

    /**
     * @return DidInterface
     */
    public function dids(): DidInterface
    {
        if (!$this->dids) {
            $this->dids = new DidInterface($this->client, $this->countryId, $this->id);
        }
        return $this->dids;
    }

}