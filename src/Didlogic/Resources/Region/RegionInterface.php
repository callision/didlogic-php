<?php


namespace Didlogic\Resources\Region;


use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;


class RegionInterface extends ResourceInterface
{
    private int $countryId;

    public function __construct(HttpClient $client, $countryId)
    {
        parent::__construct($client);
        $this->countryId = $countryId;
        $this->uri = "buy/countries/{$countryId}/regions";
    }

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