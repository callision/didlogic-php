<?php


namespace Didlogic\Resources\Region;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;


/**
 * Class RegionInterface
 * @package Didlogic\Resources\Region
 */
class RegionInterface extends ResourceInterface
{
    private $countryId;

    /**
     * RegionInterface constructor.
     * @param HttpClient $client
     * @param $countryId
     */
    public function __construct(HttpClient $client, $countryId)
    {
        parent::__construct($client);
        $this->countryId = $countryId;
        $this->uri = "buy/countries/{$countryId}/regions.json";
    }

    /**
     * @return RegionList
     * @throws RequestException
     * @throws ResponseException
     */
    public function getList(): RegionList
    {
        $response = $this->client->fetch($this->uri);
        $regions = [];
        foreach ($response->getContent()['regions'] as $region) {
            $region['country_id'] = $this->countryId;
            $regions[] = new Region($this->client, $region);
        }

        return new RegionList(...$regions);
    }
}