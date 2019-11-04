<?php


namespace Didlogic;


use Didlogic\Resources\Account\AccountInterface;
use Didlogic\Resources\Country\CountryInterface;

class RestClient
{

    protected $client;
    protected $countries;
    protected $account;

    /**
     * RestClient constructor.
     * @param null $apiKey
     */
    public function __construct($apiKey = null)
    {
        $this->client = new HttpClient($apiKey);
    }

    /**
     * @return CountryInterface
     */
    public function countries(): CountryInterface
    {
        if (!isset($this->countries)) {
            $this->countries = new CountryInterface($this->client);
        }
        return $this->countries;
    }

    /**
     * @return AccountInterface
     */
    public function account(): AccountInterface
    {
        if (!isset($this->account)) {
            $this->account = new AccountInterface($this->client);
        }
        return $this->account;
    }

}