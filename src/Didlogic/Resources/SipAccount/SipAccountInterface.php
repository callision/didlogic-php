<?php


namespace Didlogic\Resources\SipAccount;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;

/**
 * Class SipAccountInterface
 * @package Didlogic\Resources\SipAccount
 */
class SipAccountInterface extends ResourceInterface
{
    /**
     * SipAccountInterface constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        parent::__construct($client);
        $this->uri = "sipaccounts";
    }

    /**
     * @return SipAccountList
     * @throws RequestException
     * @throws ResponseException
     */
    public function getList(): SipAccountList
    {
        $uri = "{$this->uri}.json";
        $response = $this->client->fetch($uri, [], 'v1');
        $sipAccounts = [];
        foreach ($response->getContent()['sipaccounts'] as $sipaccount) {
            $sipAccounts[] = new SipAccount($this->client, $sipaccount);
        }
        return new SipAccountList(...$sipAccounts);
    }

    /**
     * @param $options
     * @return SipAccount
     * @throws RequestException
     * @throws ResponseException
     */
    public function update($options): SipAccount
    {
        $uri = "{$this->uri}}/{$options['name']}.json";
        $response = $this->client->update($uri, ['sipaccount' => $options], 'v1');
        return new SipAccount($this->client, $response->getContent()['sipaccount']);
    }

    /**
     * @param $options
     * @return SipAccount
     * @throws RequestException
     * @throws ResponseException
     */
    public function create($options): SipAccount
    {
        $uri = "{$this->uri}.json";
        $response = $this->client->create($uri, ['sipaccount' => $options], 'v1');
        return new SipAccount($this->client, $response->getContent()['sipaccount']);
    }

    /**
     * @param $options
     * @return bool
     * @throws RequestException
     * @throws ResponseException
     */
    public function delete($options)
    {
        $uri = "{$this->uri}}/{$options['name']}.json";
        $this->client->delete($uri, [], 'v1');
        return true;
    }
}