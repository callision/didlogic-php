<?php


namespace Didlogic\Resources\Did;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\Resource;


class Did extends Resource
{
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
                return ['id' => (int)$item['id'], (string)$item['name']];
            }, $data['required_documents']);
        }
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     */
    public function purchase()
    {
        $options = ["did_numbers" => [$this->getNumber()]];
        $response = $this->client->update('buy/purchase', $options);
    }
}