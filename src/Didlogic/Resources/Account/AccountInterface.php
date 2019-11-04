<?php


namespace Didlogic\Resources\Account;


use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;

class AccountInterface extends ResourceInterface
{

    public function __construct(HttpClient $client)
    {
        parent::__construct($client);
    }

    public function buyNumber($number)
    {
        $options = ["did_numbers" => [$number]];
        $response = $this->client->update('buy/purchase', $options);
    }

}