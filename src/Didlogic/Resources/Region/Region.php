<?php


namespace Didlogic\Resources\Region;


use Didlogic\HttpClient;
use Didlogic\Resources\City\CityInterface;
use Didlogic\Resources\Resource;


class Region extends Resource
{
    private $countryId;
    private $cities;

    public function __construct(HttpClient $client, $data)
    {
        parent::__construct($client);
        $this->properties = [
            'id' => (int)$data['id'],
            'countryId' => (int)$data['country_id'],
            'name' => (string)$data['name']
        ];
        $this->id = (int)$data['id'];
        $this->countryId = (int)$data['country_id'];
    }

    public function cities(): CityInterface
    {
        if (!$this->cities) {
            $this->cities = new CityInterface($this->client, $this->countryId, $this->id);
        }
        return $this->cities;
    }

}