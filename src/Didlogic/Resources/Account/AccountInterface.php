<?php


namespace Didlogic\Resources\Account;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\Did\Did;
use Didlogic\Resources\Did\DidList;
use Didlogic\Resources\ResourceInterface;

class AccountInterface extends ResourceInterface
{

    public function __construct(HttpClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param $number
     * @throws RequestException
     * @throws ResponseException
     */
    public function buyNumber($number)
    {
        $options = ["did_numbers" => [$number]];
        $response = $this->client->update('buy/purchase', $options);
    }

    /**
     * @param $options
     *   + Valid arguments
     *   + [string] number_contains
     *   + [string] begins_with
     *   + [string] ends_width
     *   + [string] city_name_contains
     *   + [string] country_name_contains
     *   + [boolean] sms_enabled
     *   + [integer] page
     * @return DidList
     * @throws RequestException
     * @throws ResponseException
     */
    public function searchNumbers(array $options): DidList
    {
        $response = $this->client->fetch('buy/search', $options);
        $dids = [];
        foreach ($response->getContent()['dids'] as $did) {
            $dids[] = new Did($this->client, $did);
        }
        return new DidList(...$dids);
    }

}