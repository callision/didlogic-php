<?php


namespace Didlogic\Resources\City;


use Didlogic\Resources\ResourceList;

class CityList extends ResourceList
{
    public function __construct(City ...$resources)
    {
        parent::__construct($resources);
    }
}