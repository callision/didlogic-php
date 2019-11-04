<?php


namespace Didlogic\Resources\Did;


use Didlogic\HttpClient;
use Didlogic\Resources\Resource;


class Did extends Resource
{
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
            "smsEnabled" => (boolean)$data['']
        ];
        if (isset($data['required_documents']) && is_array($data['required_documents'])) {
            $this->properties['required_documents'] = array_map(function ($item) {
                return ['id' => (int)$item['id'], (string)$item['name']];
            }, $data['required_documents']);
        }
    }

    public function purchase()
    {
        $options = ["did_numbers" => [$this->getNumber()]];
        $response = $this->client->update('buy/purchase', $options);
    }
}