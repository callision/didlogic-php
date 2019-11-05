<?php


namespace Didlogic\Resources\AuthorizedIp;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;

/**
 * Class AuthorizedIpInterface
 * @package Didlogic\Resources\AuthorizedIp
 */
class AuthorizedIpInterface extends ResourceInterface
{
    /**
     * @var string
     */
    private $sipAccountName;

    /**
     * AuthorizedIpInterface constructor.
     * @param HttpClient $client
     * @param $sipAccountName
     */
    public function __construct(HttpClient $client, $sipAccountName)
    {
        parent::__construct($client);
        $this->sipAccountName = $sipAccountName;
        $this->uri = "sipaccounts/$sipAccountName/allowed_ips.json";
    }

    /**
     * @return AuthorizedIpList
     * @throws RequestException
     * @throws ResponseException
     */
    public function getList(): AuthorizedIpList
    {
        $response = $this->client->fetch($this->uri, [], 'v1');
        return new AuthorizedIpList($response->getContent()['allowed_ips']);
    }

    /**
     * @param $ip
     * @return AuthorizedIpList
     * @throws RequestException
     * @throws ResponseException
     */
    public function create($ip): AuthorizedIpList
    {
        $response = $this->client->create($this->uri, ['ip' => $ip], 'v1');
        return new AuthorizedIpList($response->getContent()['allowed_ips']);
    }

    /**
     * @param $ip
     * @return bool
     * @throws RequestException
     * @throws ResponseException
     */
    public function delete($ip)
    {
        $this->client->delete($this->uri, ['ip' => $ip], 'v1');
        return true;
    }
}