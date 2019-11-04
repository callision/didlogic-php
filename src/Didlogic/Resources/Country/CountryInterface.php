<?php


namespace Didlogic\Resources\Country;


use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;
use GuzzleHttp\Exception\GuzzleException;

class CountryInterface extends ResourceInterface
{
    /**
     * CountryInterface constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        parent::__construct($client);
        $this->uri = "buy/countries";
    }

    /**
     * @return array
     * @throws ResponseException
     * @throws GuzzleException
     */
    public function getList(): CountryList
    {
        $response = $this->client->fetch($this->uri);
        $countries = [];
        foreach ($response->getContent()['countries'] as $country) {
            $countries[] = new Country($this->client, $country);
        }
        return new CountryList(...$countries);
    }

}