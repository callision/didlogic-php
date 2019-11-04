<?php


namespace Didlogic\Resources\SipAccount;


use Didlogic\Resources\ResourceList;

class SipAccountList extends ResourceList
{
    public function __construct(SipAccount ...$resources)
    {
        parent::__construct($resources);
    }
}