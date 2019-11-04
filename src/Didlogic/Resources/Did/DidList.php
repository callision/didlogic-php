<?php


namespace Didlogic\Resources\Did;


use Didlogic\Resources\ResourceList;

class DidList extends ResourceList
{
    public function __construct(Did ...$resources)
    {
        parent::__construct($resources);
    }
}