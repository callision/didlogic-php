<?php


namespace Didlogic\Resources\Country;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;

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
     * @return CountryList
     * @throws RequestException
     * @throws ResponseException
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