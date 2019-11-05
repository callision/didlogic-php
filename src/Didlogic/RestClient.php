<?php


namespace Didlogic;


use Didlogic\Resources\Account\AccountInterface;
use Didlogic\Resources\Country\CountryInterface;
use Didlogic\Resources\SipAccount\SipAccountInterface;

/**
 * Class RestClient
 * @package Didlogic
 */
class RestClient
{

    /**
     * @var HttpClient
     */
    protected $client;
    /**
     * @var CountryInterface
     */
    protected $countries;
    /**
     * @var SipAccountInterface
     */
    protected $sipAccounts;
    /**
     * @var AccountInterface
     */
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

    /**
     * @return SipAccountInterface
     */
    public function sipAccounts(): SipAccountInterface
    {
        if (!isset($this->sipAccounts)) {
            $this->sipAccounts = new SipAccountInterface($this->client);
        }
        return $this->sipAccounts;
    }

}