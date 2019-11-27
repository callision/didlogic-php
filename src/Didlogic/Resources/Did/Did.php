<?php


namespace Didlogic\Resources\Did;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\Destination\DestinationInterface;
use Didlogic\Resources\Resource;


/**
 * @property string number
 * @property double activation
 * @property double monthly
 * @property double perMinute
 * @property int channels
 * @property string country
 * @property string city
 * @property boolean smsEnabled
 */
class Did extends Resource
{
    /**
     * @var bool
     */
    private $purchased = false;
    /**
     * @var DestinationInterface
     */
    private $destinationInterface;

    /**
     * Did constructor.
     * @param HttpClient $client
     * @param $data
     */
    public function __construct(HttpClient $client, $data)
    {
        parent::__construct($client);
        $this->properties = [
            "number" => (string)$data['number'],
            "activation" => (double)$data['activation'],
            "monthly" => (double)$data['monthly'],
            "perMinute" => (double)$data['per_minute'],
            "channels" => (int)$data['channels'],
            "country" => (string)$data['country'],
            "city" => (string)$data['city'],
            "smsEnabled" => (boolean)$data['sms_enabled']
        ];
        if (isset($data['required_documents']) && is_array($data['required_documents'])) {
            $this->properties['requiredDocuments'] = array_map(function ($item) {
                return ['id' => (int)$item['type'], (string)$item['name']];
            }, $data['required_documents']);
        }
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     */
    public function purchase()
    {
        $options = ["did_numbers" => [$this->number]];
        $response = $this->client->update('buy/purchase', $options);
        $this->purchased = true;
    }

    /**
     * @return bool
     */
    public function isPurchased()
    {
        return $this->purchased;
    }

    /**
     * @return DestinationInterface
     */
    public function destinations(): DestinationInterface
    {
        if (!$this->destinationInterface) {
            $this->destinationInterface = new DestinationInterface($this->client, $this->number);
        }
        return $this->destinationInterface;
    }
}