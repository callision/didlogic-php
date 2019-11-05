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
    /**
     * @var RegionInterface
     */
    private $regions;
    /**
     * @var CityInterface
     */
    private $cities;

    /**
     * Country constructor.
     * @param HttpClient $client
     * @param $data
     */
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

    /**
     * @return CityInterface
     */
    public function cities(): CityInterface
    {
        if (!$this->cities) {
            $this->cities = new CityInterface($this->client, $this->id);
        }
        return $this->cities;
    }

    /**
     * @return RegionInterface
     */
    public function regions(): RegionInterface
    {
        if (!$this->regions) {
            $this->regions = new RegionInterface($this->client, $this->id);
        }
        return $this->regions;
    }

}