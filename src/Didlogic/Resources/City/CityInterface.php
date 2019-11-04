<?php


namespace Didlogic\Resources\City;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;

class CityInterface extends ResourceInterface
{
    private $countryId;
    private $regionId;

    /**
     * CityInterface constructor.
     * @param HttpClient $client
     * @param $countryId
     * @param null $regionId
     */
    public function __construct(HttpClient $client, $countryId, $regionId = null)
    {
        parent::__construct($client);
        $this->countryId = $countryId;
        if (!$regionId) {
            $this->uri = "buy/countries/{$countryId}/cities";
        } else {
            $this->regionId = $regionId;
            $this->uri = "buy/countries/{$countryId}/regions/{$regionId}cities";
        }
    }

    /**
     * @return CityList
     * @throws RequestException
     * @throws ResponseException
     */
    public function getList(): CityList
    {
        $response = $this->client->fetch($this->uri);
        $cities = [];
        foreach ($response->getContent()['cities'] as $city) {
            $city['country_id'] = $this->countryId;
            $cities[] = new City($this->client, $city);
        }

        return new CityList(...$cities);
    }
}