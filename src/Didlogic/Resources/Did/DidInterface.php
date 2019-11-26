<?php


namespace Didlogic\Resources\Did;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\ResourceInterface;
use GuzzleHttp\Exception\GuzzleException;


/**
 * Class DidInterface
 * @package Didlogic\Resources\Did
 */
class DidInterface extends ResourceInterface
{
    private $countryId;
    private $cityId;
    private $totalPages;
    private $currentPage;

    /**
     * DidInterface constructor.
     * @param HttpClient $client
     * @param $countryId
     * @param $cityId
     */
    public function __construct(HttpClient $client, $countryId, $cityId)
    {
        parent::__construct($client);
        $this->countryId = $countryId;
        $this->cityId = $cityId;
        $this->uri = "buy/countries/{$countryId}/cities/{$cityId}/dids.json";
    }

    /**
     * @param array $options
     *   + Valid arguments
     *   + [int] page
     * @return DidList
     * @throws RequestException
     * @throws ResponseException
     */
    public function getList($options = []): DidList
    {
        $response = $this->client->fetch($this->uri, $options);
        $dids = [];
        foreach ($response->getContent()['dids']['dids'] as $did) {
            $dids[] = new Did($this->client, $did);
        }
        $this->totalPages = (int)$response->getContent()['dids']['pagination']['total_pages'];
        $this->currentPage = (int)$response->getContent()['dids']['pagination']['current_page'];
        return new DidList(...$dids);
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

}