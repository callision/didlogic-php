<?php


namespace Didlogic\Resources\Country;


use Didlogic\HttpClient;
use Didlogic\Resources\Region\RegionInterface;
use Didlogic\Resources\Resource;
use Didlogic\Resources\City\CityInterface;


/**
 * Class Country
 * @package Didlogic\Resources\Country
 */
class Country extends Resource
{
    private $regions;
    private $cities;

    public function __construct(HttpClient $client, $data)
    {
        parent::__construct($client);
        $this->properties = [
            'id' => (int)$data['id'],
            'name' => (string)$data['name'],
            'hasProvincesOrStates' => (boolean)$data['has_provinces_or_states']
        ];
        $this->id = $data['id'];
    }

    public function cities(): CityInterface
    {
        if (!$this->cities) {
            $this->cities = new CityInterface($this->client, $this->id);
        }
        return $this->cities;
    }

    public function regions(): RegionInterface
    {
        if (!$this->regions) {
            $this->regions = new RegionInterface($this->client, $this->id);
        }
        return $this->regions;
    }

}