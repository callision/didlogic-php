<?php


namespace Didlogic\Resources\Region;


use Didlogic\Resources\ResourceList;

class RegionList extends ResourceList
{
    public function __construct(Region ...$resources)
    {
        parent::__construct($resources);
    }
}