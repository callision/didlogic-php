<?php


namespace Didlogic\Resources\SipAccount;


use Didlogic\Exceptions\RequestException;
use Didlogic\Exceptions\ResponseException;
use Didlogic\HttpClient;
use Didlogic\Resources\Resource;

/**
 * @property mixed|null params
 */
class SipAccount extends Resource
{
    private $interface;

    /**
     * SipAccount constructor.
     * @param HttpClient $client
     * @param array $data
     */
    public function __construct(HttpClient $client, array $data)
    {
        parent::__construct($client);
        $this->properties = [
            "name" => (string)$data["name"],
            "callerid" => (string)$data["callerid"],
            "label" => (string)$data["label"],
            "charge" => (double)$data["charge"],
            "talkTime" => (int)$data["talk_time"],
            "rewriteEnabled" => (bool)$data["rewrite_enabled"],
            "rewriteCond" => (string)$data["rewrite_cond"],
            "rewritePrefix" => (string)$data["rewrite_prefix"],
            "didinfoEnabled" => (bool)$data["didinfo_enabled"],
            "ipRestrict" => (bool)$data["ip_restrict"],
            "callRestrict" => (bool)$data["call_restrict"],
            "callLimit" => (int)$data["call_limit"],
            "channelsRestrict" => (bool)$data["channels_restrict"],
            "maxChannels" => (int)$data["max_channels"],
            "costLimit" => (bool)$data["cost_limit"],
            "maxCallCost" => (double)$data["max_call_cost"]
        ];
    }

    /**
     * @param $value
     */
    public function setPassword($value)
    {
        $this->properties['password'] = $value;
    }

    /**
     * @return SipAccountInterface
     */
    private function getInterface(): SipAccountInterface
    {
        if (!$this->interface) {
            $this->interface = new SipAccountInterface($this->client);
        }
        return $this->interface;
    }

    /**
     * @return SipAccount
     * @throws RequestException
     * @throws ResponseException
     */
    public function update(): SipAccount
    {
        return $this->getInterface()->update($this->params);
    }

    /**
     * @return bool
     * @throws RequestException
     * @throws ResponseException
     */
    public function delete()
    {
        return $this->getInterface()->delete($this->params);
    }
}